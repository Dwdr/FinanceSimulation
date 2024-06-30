<?php

namespace App\Console\Commands;

use App\Jobs\ProcessGeneratorPayroll;
use App\Models\EH\Employee;
use App\Models\EH\Configurations\Holiday;
use App\Models\System\JobOrder;
use App\Traits\EmployeeAuditLog;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class GeneratorPayroll extends Command {

    use EmployeeAuditLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eh:generator_payroll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check and effective generator payroll';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        // select today effective employee movement record
        $jobs = JobOrder::where('type',config('constants.JOB.TYPE.GENERATOR_PAYROLL'))
            ->where('effective_type', config('constants.PAYROLL.GENERATE_DATE.SELECT_DATE'))
            ->where('effective_date', '<=', Carbon::today())
            ->where('status', config('constants.JOB.STATUS.PENDING'))
            ->get();

        Log::info("[Commands] [Generator Payroll effective] record find: " . count($jobs));

        foreach ($jobs as $j) {
            $j->status = config('constants.JOB.STATUS.PROCESSING');
            $j->save();
            $holiday_list = Holiday::all();
            foreach($j->payload['employee'] as $e_uuid){
                $e = Employee::findOrFail($e_uuid);
                dispatch(new ProcessGeneratorPayroll($j,$e,$j->payload['period_start'],$j->payload['period_end'],$holiday_list));
            }

            Log::info("[Commands] [Generator Payroll effective] record start queue: " . $j->uuid);
        }
    }
}
