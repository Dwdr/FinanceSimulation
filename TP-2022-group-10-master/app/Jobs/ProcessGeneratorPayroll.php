<?php

namespace App\Jobs;

use App\Models\EH\Employee;
use App\Models\EH\M1\PayrollRecord;
use App\Models\System\JobOrder;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProcessGeneratorPayroll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $job_order;
    public $employee;
    public $period_start;
    public $period_end;
    public $holiday;
    public $debug;


    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;


    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(JobOrder $job_order, Employee $employee,$period_start,$period_end,$holiday,$debug = false)
    {
        $this->job_order = $job_order;
        $this->employee = $employee;
        $this->period_start = $period_start;
        $this->period_end = $period_end;
        $this->holiday = $holiday;
        $this->debug = $debug;
    }

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    public $failOnTimeout = true;

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Illuminate\Http\Client\RequestException
     * @throws Exception
     */
    public function handle()
    {
        // check last payroll status is not pending
        $last_payroll_count = PayrollRecord::where('employee_uuid',$this->employee->uuid)
            ->where('status',config('constants.PAYROLL.STATUS.PENDING'))
            ->count();

        if($last_payroll_count > 0){
            $error = 'Employee have pending payroll record.';
            if(!$this->debug){
                throw new Exception($error);
            }
        }

        $s3_period_start = date('Y-m-d', strtotime($this->period_start));
        $s3_period_end = date('Y-m-d', strtotime($this->period_end));

        //line total variables
        $total_basic = 0;
        $total_leave = 0;
        $total_holiday = 0;
        $total_ri = 0;
        $total_mpf = 0;
        $total_grand = 0;

        $s3_employee_start_year = date("Y", strtotime($this->employee->package[0]['effective_date']));
        $s3_employee_start_month = date("m", strtotime($this->employee->package[0]['effective_date']));
        $s3_employee_start_day = date("d", strtotime($this->employee->package[0]['effective_date']));

        // TODO Jimmy:  @PY, if plz check is need
        //add logic handle leave date
        $s3_employee_end_year = date("Y", strtotime('2025-12-31'));
        $s3_employee_end_month = date("m", strtotime('2025-12-31'));
        $s3_employee_end_day = date("d", strtotime('2025-12-31'));

        $s3_period_start_year = date("Y", strtotime($s3_period_start));
        $s3_period_start_month = date("m", strtotime($s3_period_start));
        $s3_period_end_year = date("Y", strtotime($s3_period_end));
        $s3_period_end_month = date("m", strtotime($s3_period_end));

        $s3_cal_day = cal_days_in_month(CAL_GREGORIAN, $s3_period_start_month, $s3_period_start_year);

        $s3_mpf_employer_compulsory = $this->employee->package[0]['detail']['mpf_employer_compulsory'];
        $s3_mpf_employer_voluntary = $this->employee->package[0]['detail']['mpf_employer_voluntary'];
        $s3_mpf_employee_compulsory = $this->employee->package[0]['detail']['mpf_employee_compulsory'];
        $s3_mpf_employee_voluntary = $this->employee->package[0]['detail']['mpf_employee_voluntary'];

        // Basic
        $s3_basic = $this->employee->package[0]['detail']['basic_salary'];
        foreach ($this->employee->package as $p) {
            if (strcmp($p['effective_date'], $s3_period_start) <= 0) {
                $s3_basic = $p['detail']['basic_salary'];
            } else {
                break;
            }


            // $compare_to = strcmp($salary_history[$k]['since'], $s3_period_start);
            // if(strcmp($salary_history[$k]['since'], $s3_period_start) <0 ){
            //     $pick = $salary_history[$k]['since'];
            // }else{
            //     $pick = $s3_period_start;
            // }
            // echo "salary_history: ".$salary_history[$k]['since']." | s3_period_start: $s3_period_start | $compare_to | $pick <br>";
            //$datediff = strtotime($pick_to) - strtotime($pick_from);
        }
        $total_basic = $s3_basic;

        // Leave
        $leave_selected_array = array();

        //step 1: check if the leave records full within the calculation period
        //TODO improvement, use sql statement to filter
        //TODO improvement, should co-join table leaves_config
        foreach ($this->employee->leave_application as $lr) {
            $lr_status = $lr['status'];
            $lr_period_start_year = date('Y', strtotime($lr['period_start']));
            $lr_period_start_month = date('m', strtotime($lr['period_start']));
            $lr_period_start_day = date('d', strtotime($lr['period_start']));
            $lr_period_end_year = date('Y', strtotime($lr['period_end']));
            $lr_period_end_month = date('m', strtotime($lr['period_end']));
            $lr_period_end_day = date('d', strtotime($lr['period_end']));

            //check if $s3_period_start_year = $lr_period_start_year &&
            //check if $s3_period_start_moth = $lr_period_start_month
            if (($s3_period_start_year == $lr_period_start_year) && ($s3_period_start_month == $lr_period_start_month)) {
                //push the leave record array to the selected array
                $data = [
                    'leave' => $lr,
                    'is_nwd' => 0,
                    'is_adj' => 0,
                    'is_rse' => 0,
                ];
                array_push($leave_selected_array, $data);
            }
        }

        //step 2: calculate past 12/mo acc salary and workday (wd)
        //this should be read from table, now use manual input
        // TODO cal 12/mo
        //  max /12
        //  min /1
        $acc_12m_salary = 29677.42;
        $acc_12m_wd = 89;

        //step 3: get the detail of the leave type with parameters config
        for ($l = 0; $l < sizeof($leave_selected_array); $l++) {
            //print the detail of the selected array, make sure data extracted are correct
            $status = $leave_selected_array[$l]['leave']['status'];
            $period_start = $leave_selected_array[$l]['leave']['period_start'];
            $period_end = $leave_selected_array[$l]['leave']['period_end'];
            $period_days = $this->daysInAPeriod($s3_period_start, $s3_period_end, $period_start, $period_end);
            $is_nwd = $leave_selected_array[$l]['leave']->leaveType->is_nwd;
            $is_adj = $leave_selected_array[$l]['leave']->leaveType->is_adj;
            $is_rse = $leave_selected_array[$l]['leave']->leaveType->is_rse;
            $percentage = $leave_selected_array[$l]['leave']->leaveType->percentage;

            //calculate the non-workday (NWD) deduction
            if ($is_nwd) {
                $is_nwd_count = $this->computeNwd($period_days, $s3_basic, $s3_cal_day) * -1;
                $leave_selected_array[$l]['is_nwd'] = $is_nwd_count;
                $total_leave += $is_nwd_count;
            }

            //calculate the rse (RSE) addition
            //compute the addition or subtraction based on different type of leaves
            if ($is_adj) {
                if ($is_rse) {
                    $is_rse_count = $this->computeAdjRse($period_days, $percentage, $acc_12m_salary, $acc_12m_wd);
                    $leave_selected_array[$l]['is_rse'] = $is_rse_count;
                    $total_leave += $is_rse_count;
                } else {
                    $is_adj_count = $this->computeAdj($period_days, $percentage, $s3_basic, $s3_cal_day);
                    $leave_selected_array[$l]['is_adj'] = $is_adj_count;
                    $total_leave += $is_adj_count;
                }
            }
        }

        //Holiday
        $holiday_selected_array = array();

        //step 1: check if the leave records full within the calculation period
        //TODO improvement, use sql statement to filter
        //TODO improvement, should co-join table leaves_config
        foreach ($this->holiday as $h) {

            $hr_date_year = date('Y', strtotime($h['date']));
            $hr_date_month = date('m', strtotime($h['date']));

            //check if $s3_period_start_year = $lr_period_start_year &&
            //check if $s3_period_start_moth = $lr_period_start_month
            if (($s3_period_start_year == $hr_date_year) && ($s3_period_start_month == $hr_date_month)) {
                //push the leave record array to the selected array
                $data = [
                    'holiday' =>  $h,
                    'is_nwd' => 0,
                    'is_adj' => 0,
                    'is_rse' => 0,
                ];
                array_push($holiday_selected_array, $data);
            }
        }

        for ($h = 0; $h < sizeof($holiday_selected_array); $h++) {
            //print the detail of the selected array, make sure data extracted are correct
            $type = $holiday_selected_array[$h]['holiday']['type'];
            $period_start = $holiday_selected_array[$h]['holiday']['date'];
            $period_end = $holiday_selected_array[$h]['holiday']['date'];
            $period_days = $this->daysInAPeriod($s3_period_start, $s3_period_end, $period_start, $period_end);
            $is_nwd = $holiday_selected_array[$h]['holiday']->type->is_nwd;
            $is_adj = $holiday_selected_array[$h]['holiday']->type->is_adj;
            $is_rse = $holiday_selected_array[$h]['holiday']->type->is_rse;
            $percentage = $holiday_selected_array[$h]['holiday']->type->percentage;

            //calculate the non-workday (NWD) deduction
            if ($is_nwd) {
                $is_nwd_count = $this->computeNwd($period_days, $s3_basic, $s3_cal_day) * -1;
                $holiday_selected_array[$h]['is_nwd'] = $is_nwd_count;
                $total_holiday += $is_nwd_count;
            }

            //calculate the rse (RSE) addition
            //compute the addition or subtraction based on different type of leaves
            if ($is_adj) {
                if ($is_rse) {
                    $is_rse_count = $this->computeAdjRse($period_days, $percentage, $acc_12m_salary, $acc_12m_wd);
                    $holiday_selected_array[$h]['is_rse'] = $is_rse_count;
                    $total_holiday += $is_rse_count;
                } else {
                    $is_adj_count = $this->computeAdj($period_days, $percentage, $s3_basic, $s3_cal_day);
                    $holiday_selected_array[$h]['is_adj'] = $is_adj_count;
                    $total_holiday += $is_adj_count;
                }
            }
        }

        // Revalent income (RI)
        $total_ri = $total_basic + $total_leave + $total_holiday;

        //MPF
        $mpf_employer_compulsory = $total_ri * $s3_mpf_employer_compulsory / 100;
        $mpf_employee_compulsory = $total_ri * $s3_mpf_employee_compulsory / 100;
        $mpf_employer_voluntary = $total_ri * $s3_mpf_employer_voluntary / 100;
        $mpf_employee_voluntary = $total_ri * $s3_mpf_employee_voluntary / 100;

        $total_mpf = $mpf_employee_compulsory + $mpf_employee_voluntary;

        //Grand Total
        $total_grand = $total_ri - $total_mpf;

        $payroll_record = [
            "s3_period_start" => $s3_period_start??'',
            "s3_period_end" => $s3_period_end??'',
            "preparation" => [
                "s3_employee_start_year" => $s3_employee_start_year??'',
                "s3_employee_start_month" => $s3_employee_start_month??'',
                "s3_employee_start_day" => $s3_employee_start_day??'',
                "s3_employee_end_year" => $s3_employee_end_year??'',
                "s3_employee_end_month" => $s3_employee_end_month??'',
                "s3_employee_end_day" => $s3_employee_end_day??'',
                "s3_period_start_year" => $s3_period_start_year??'',
                "s3_period_start_month" => $s3_period_start_month??'',
                "s3_period_end_year" => $s3_period_end_year??'',
                "s3_period_end_month" => $s3_period_end_month??'',
                "s3_cal_day" => $s3_cal_day??'',
                "s3_mpf_employer_compulsory" => $s3_mpf_employer_compulsory??'',
                "s3_mpf_employer_voluntary" => $s3_mpf_employer_voluntary??'',
                "s3_mpf_employee_compulsory" => $s3_mpf_employee_compulsory??'',
                "s3_mpf_employee_voluntary" => $s3_mpf_employee_voluntary??'',
            ],
            "basic" => [
                "s3_basic" => $s3_basic??'',
                "total_basic" => $total_basic??'',
            ],
            "leave" => [
                "selected_array" => $leave_selected_array??'',
                "acc_12m_salary" => $acc_12m_salary??'',
                "acc_12m_wd" => $acc_12m_wd??'',
                "total_leave" => $total_leave??'',
            ],
            "holiday" => [
                "selected_array" => $holiday_selected_array??'',
                "total_holiday" => $total_holiday??'',
            ],
            "ri" => [
                "total_ri" => $total_ri??'',
            ],
            "mpf" => [
                "mpf_employer_compulsory" => $mpf_employer_compulsory??'',
                "mpf_employee_compulsory" => $mpf_employee_compulsory??'',
                "mpf_employer_voluntary" => $mpf_employer_voluntary??'',
                "mpf_employee_voluntary" => $mpf_employee_voluntary??'',
                "total_mpf" => $total_mpf??'',
            ],
            "grand_total" => $total_grand??''
        ];

        $adjustment = [

        ];

        $payroll = PayrollRecord::create([
            "uuid" => Str::uuid(),
            "organization_id" => $this->employee->organization_id,
            "creator_id" => 1,
            "employee_uuid" => $this->employee->uuid,
            "period_start" => $s3_period_start,
            "period_end" => $s3_period_end,
            "generator" => serialize($payroll_record),
            "adjustment" => serialize($adjustment),
            "status" => config('constants.PAYROLL.STATUS.PENDING')
        ]);

        $success_record = $this->job_order->success_record;
        array_push($success_record,$this->employee->uuid);
        $this->job_order->success_record = serialize($success_record);

        if((sizeof($this->job_order->success_record) + sizeof($this->job_order->fail_record)) == $this->job_order->job_count){
            if($this->job_order->status == config('constants.JOB.STATUS.PROCESSING')){
                $this->job_order->status = config('constants.JOB.STATUS.FINISH');
            }
        }
        $this->job_order->save();

        if($this->debug){
            $payroll->status = config('constants.PAYROLL.STATUS.CONFIRMED');
            $payroll->save();
        }
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...

        // record fail job.
        $fail_record = $this->job_order->fail_record;
        $fail = [
            'employee_uuid' => $this->employee->uuid,
            'exception' => $exception->getMessage(),
        ];
        array_push($fail_record,$fail);
        $this->job_order->fail_record = serialize($fail_record);
        $this->job_order->save();
    }

    function daysInAPeriod($period_from, $period_to, $from, $to) {
        //following is TODO
        //check if leave period start date < period start day ?!?!?!
        //e.g. leave between 1/5-31/8, this period month is June (6) ?!?!?!
        //so take 1/6-30/6 ?!?!?!
        //check if leave period end date > period end day ?!?!?!
        //e.g. leave between 1/5-31/8, this period month is June (6) ?!?!?!

        //parially done
        $compare_from = strcmp($period_from, $from);
        if (strcmp($period_from, $from) >= 0) {
            $pick_from = $period_from;
        } else {
            $pick_from = $from;
        }
        // echo "period_from: $period_from | from: $from | $compare_from  | $pick_from <br>";

        $compare_to = strcmp($period_to, $to);
        if (strcmp($period_to, $to) < 0) {
            $pick_to = $period_to;
        } else {
            $pick_to = $to;
        }
        // echo "period_to: $period_to | to: $to | $compare_to | $pick_to <br>";

        $datediff = strtotime($pick_to) - strtotime($pick_from);
        return round($datediff / (60 * 60 * 24)) + 1;
    }

    function computeNwd($period_days, $s3_basic, $s3_cal_day) {
        $nwd = $period_days;
        return ($s3_basic / $s3_cal_day) * $nwd;
    }

    function computeAdj($period_days, $percentage, $s3_basic, $s3_cal_day) {
        $nwd = $period_days;
        $percentage = $percentage / 100;
        return ($s3_basic / $s3_cal_day) * $nwd * $percentage;
    }

    function computeAdjRse($period_days, $percentage, $acc_12m_salary, $acc_12m_wd) {
        $nwd = $period_days;
        $percentage = $percentage / 100;
        return ($acc_12m_salary / $acc_12m_wd) * $nwd * $percentage;
    }
}
