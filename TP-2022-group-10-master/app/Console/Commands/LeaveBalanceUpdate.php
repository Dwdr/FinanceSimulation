<?php

namespace App\Console\Commands;

use App\Models\Auth\User;
use App\Models\EH\Employee;
use App\Models\EH\LeaveBalance;
use App\Models\EH\Configurations\Department;
use App\Models\EH\Configurations\Designation;
use App\Models\EH\Configurations\EmployeeType;
use App\Models\EH\Configurations\LeaveType;
use App\Traits\EmployeeAuditLog;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class LeaveBalanceUpdate extends Command {

    use EmployeeAuditLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eh:leave_balance_update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check employee leave balance and update.';

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
        $leave_balance = \App\Models\EH\LeaveBalance::where('reset_date', Carbon::today())->get();

        Log::info("[Commands] [Leave Balance Update] record find: " . count($leave_balance));

        foreach ($leave_balance as $lb) {
            $this->setEmployeeBalance($lb->leaveType,$lb->employee,$lb);
            Log::info("[Commands] [Leave Balance Update] record update: " . $lb->employee->uuid);
        }
    }

    public function setEmployeeBalance($leave_type,$employee,$balance) {

        //獲取符合可視範圍的員工
        $employees = [];
        $employees += [$employee->uuid => $employee->join_date];

        $max = $balance->max_balance;
        $using = $balance->using_balance??0;
        $adjustment = $balance->adjustment??0;
        $last_balance = ($max-$using+$adjustment)<0?0:($max-$using+$adjustment);

        // ------------------------

        //判斷請假類別

        // 如果是一般假期
        if ($leave_type->type == config('constants.LEAVE_TYPE.TYPE.GENERAL')) {

            //預設起始請假天數
            $default_max_balance = $leave_type->settings['default_max_balance'];
            // 每多少年增加一次
            $cycle_add_each = $leave_type->settings['cycle_add_each'];
            // 每次增加多少假期
            $cycle_add_day = $leave_type->settings['cycle_add_day'];
            // 最多增加到幾天
            $cycle_add_max = $leave_type->settings['cycle_add_max'];
            // 可以帶多少天到下一年
            $cycle_keep_balance = $leave_type->settings['cycle_keep_balance'];

            if($cycle_keep_balance>0){
                if($cycle_keep_balance>$last_balance){
                    $cycle_keep_balance = $last_balance;
                }
            }

            if ($leave_type->settings['billing_cycle'] == config('constants.LEAVE_TYPE.BILLING_CYCLE.YEAR')) {

                // 判斷結算起始日類型
                // 按照員工入職日
                if ($leave_type->settings['cycle_start_day'] == config('constants.LEAVE_TYPE.CYCLE_START_DAY.JOIN_DAY')) {

                    // 判斷下一結算日類型
                    // 按照員工入職日計算，即year +1
                    if ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.JOIN_DAY')) {
                        foreach ($employees as $uuid => $join_date) {
                            // cal employee max balance
                            $start = new DateTime($join_date);
                            $now = new DateTime();

                            $diff = $now->diff($start);
                            $times = $diff->y;

                            $reset_date = date('Y-m-d', strtotime('+' . ($times + 1) . ' year', strtotime($join_date)));

                            $max = $default_max_balance + $cycle_keep_balance;
                            if ($times > 0) {
                                for ($i = 0; $i < $times; $i += $cycle_add_each) {
                                    if ($max + $cycle_add_day < $cycle_add_max) {
                                        $max += $cycle_add_day;
                                    } else {
                                        $max = $cycle_add_max;
                                    }
                                }
                            } else {
                                $max = $default_max_balance;
                            }


                            $balance = LeaveBalance::create([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ]);
                            $balance->max_balance = $max;
                            $balance->reset_date = $reset_date;
                            $balance->save();
                        }
                    } // 按照自然日計算，即下一年的一月一號
                    elseif ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.NATURE_DAY')) {
                        $endDate = new DateTime('1st January Next Year');
                        $reset_date = $endDate->format('Y-m-d');

                        // create employee balance
                        foreach ($employees as $uuid => $join_date) {

                            // cal employee max balance
                            $start = new DateTime($join_date);
                            $now = new DateTime($reset_date);

                            $diff = $now->diff($start);
                            $times = $diff->y;

                            $max = $default_max_balance + $cycle_keep_balance;
                            if ($times > 0) {
                                for ($i = 0; $i < $times; $i += $cycle_add_each) {
                                    if ($max + $cycle_add_day < $cycle_add_max) {
                                        $max += $cycle_add_day;
                                    } else {
                                        $max = $cycle_add_max;
                                    }
                                }
                            } else {
                                $max = $default_max_balance;
                            }

                            $balance = LeaveBalance::create([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ]);
                            $balance->max_balance = $max;
                            $balance->reset_date = $reset_date;
                            $balance->save();
                        }
                    }

                } // 按照創建日開始計算
                elseif ($leave_type->settings['cycle_start_day'] == config('constants.LEAVE_TYPE.CYCLE_START_DAY.CREATE_DAY')) {

                    // 判斷下一結算日類型
                    // 按照員工入職日計算，即year +1
                    if ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.JOIN_DAY')) {
                        foreach ($employees as $uuid => $join_date) {
                            // cal employee max balance
                            $start = new DateTime($join_date);
                            $create = new DateTime($balance->created_at);
                            $now = new DateTime();

                            $diff = $now->diff($start);
                            $create_diff = $now->diff($create);
                            $times = $diff->y;
                            $create_times = $create_diff->y;

                            $reset_date = date('Y-m-d', strtotime('+' . ($times + 1) . ' year', strtotime($join_date)));

                            $max = $default_max_balance + $cycle_keep_balance;
                            if ($create_times > 0) {
                                for ($i = 0; $i < $create_times; $i += $cycle_add_each) {
                                    if ($max + $cycle_add_day < $cycle_add_max) {
                                        $max += $cycle_add_day;
                                    } else {
                                        $max = $cycle_add_max;
                                    }
                                }
                            } else {
                                $max = $default_max_balance;
                            }

                            $balance = LeaveBalance::firstOrCreate([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ]);
                            $balance->max_balance = $max;
                            $balance->reset_date = $reset_date;
                            $balance->save();
                        }
                    } // 按照自然日計算，即下一年的一月一號
                    elseif ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.NATURE_DAY')) {
                        $endDate = new DateTime('1st January Next Year');
                        $reset_date = $endDate->format('Y-m-d');

                        // cal employee max balance
                        $create = new DateTime($balance->created_at);
                        $now = new DateTime();

                        $create_diff = $now->diff($create);
                        $create_times = $create_diff->y;

                        $max = $default_max_balance + $cycle_keep_balance;
                        if ($create_times > 0) {
                            for ($i = 0; $i < $create_times; $i += $cycle_add_each) {
                                if ($max + $cycle_add_day < $cycle_add_max) {
                                    $max += $cycle_add_day;
                                } else {
                                    $max = $cycle_add_max;
                                }
                            }
                        } else {
                            $max = $default_max_balance;
                        }

                        // create employee balance
                        foreach ($employees as $uuid => $join_date) {

                            $balance = LeaveBalance::create([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ]);
                            $balance->max_balance = $max;
                            $balance->reset_date = $reset_date;
                            $balance->save();
                        }
                    }

                }
            } // 按月結算
            elseif ($leave_type->settings['billing_cycle'] == config('constants.LEAVE_TYPE.BILLING_CYCLE.MONTH')) {
                // 判斷結算起始日類型
                // 按照員工入職日
                if ($leave_type->settings['cycle_start_day'] == config('constants.LEAVE_TYPE.CYCLE_START_DAY.JOIN_DAY')) {

                    // 判斷下一結算日類型
                    // 按照員工入職日計算，即year +1
                    if ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.JOIN_DAY')) {
                        foreach ($employees as $uuid => $join_date) {
                            // cal employee max balance
                            $start = $join_date;
                            $now = date('Y-m-d');

                            $ts_start = strtotime($start);
                            $ts_now = strtotime($now);

                            $start_year = date('Y', $ts_start);
                            $now_year = date('Y', $ts_now);

                            $start_month = date('m', $ts_start);
                            $now_month = date('m', $ts_now);

                            $diff = (($now_year - $start_year) * 12) + ($now_month - $start_month);
                            $times = $diff;

                            $reset_date = date('Y-m-d', strtotime('+' . ($times + 1) . ' month', strtotime($join_date)));

                            $max = $default_max_balance + $cycle_keep_balance;
                            if ($times > 0) {
                                for ($i = 0; $i < $times; $i += $cycle_add_each) {
                                    if ($max + $cycle_add_day < $cycle_add_max) {
                                        $max += $cycle_add_day;
                                    } else {
                                        $max = $cycle_add_max;
                                    }
                                }
                            } else {
                                $max = $default_max_balance;
                            }


                            $balance = LeaveBalance::create([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ]);
                            $balance->max_balance = $max;
                            $balance->reset_date = $reset_date;
                            $balance->save();
                        }
                    } // 按照自然日計算，即下一月一號
                    elseif ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.NATURE_DAY')) {
                        $endDate = new DateTime('first day of next month');
                        $reset_date = $endDate->format('Y-m-d');

                        // create employee balance
                        foreach ($employees as $uuid => $join_date) {

                            // cal employee max balance
                            $start = $join_date;
                            $now = date('Y-m-d');

                            $ts_start = strtotime($start);
                            $ts_now = strtotime($now);

                            $start_year = date('Y', $ts_start);
                            $now_year = date('Y', $ts_now);

                            $start_month = date('m', $ts_start);
                            $now_month = date('m', $ts_now);

                            $diff = (($now_year - $start_year) * 12) + ($now_month - $start_month);
                            $times = $diff;

                            $max = $default_max_balance + $cycle_keep_balance;
                            if ($times > 0) {
                                for ($i = 0; $i < $times; $i += $cycle_add_each) {
                                    if ($max + $cycle_add_day < $cycle_add_max) {
                                        $max += $cycle_add_day;
                                    } else {
                                        $max = $cycle_add_max;
                                    }
                                }
                            } else {
                                $max = $default_max_balance;
                            }

                            $balance = LeaveBalance::create([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ]);
                            $balance->max_balance = $max;
                            $balance->reset_date = $reset_date;
                            $balance->save();
                        }
                    }

                } // 按照創建日開始計算
                elseif ($leave_type->settings['cycle_start_day'] == config('constants.LEAVE_TYPE.CYCLE_START_DAY.CREATE_DAY')) {

                    // 判斷下一結算日類型
                    // 按照員工入職日計算，即month +1
                    if ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.JOIN_DAY')) {
                        foreach ($employees as $uuid => $join_date) {
                            // cal employee max balance
                            $start = $join_date;
                            $now = date('Y-m-d');

                            $ts_start = strtotime($start);
                            $ts_now = strtotime($now);

                            $start_year = date('Y', $ts_start);
                            $now_year = date('Y', $ts_now);

                            $start_month = date('m', $ts_start);
                            $now_month = date('m', $ts_now);

                            $diff = (($now_year - $start_year) * 12) + ($now_month - $start_month);
                            $times = $diff;

                            // cal employee max balance
                            $start = $leave_type->created_at;
                            $now = date('Y-m-d');

                            $ts_start = strtotime($start);
                            $ts_now = strtotime($now);

                            $start_year = date('Y', $ts_start);
                            $now_year = date('Y', $ts_now);

                            $start_month = date('m', $ts_start);
                            $now_month = date('m', $ts_now);

                            $diff = (($now_year - $start_year) * 12) + ($now_month - $start_month);
                            $create_times = $diff;

                            $max = $default_max_balance + $cycle_keep_balance;
                            if ($create_times > 0) {
                                for ($i = 0; $i < $create_times; $i += $cycle_add_each) {
                                    if ($max + $cycle_add_day < $cycle_add_max) {
                                        $max += $cycle_add_day;
                                    } else {
                                        $max = $cycle_add_max;
                                    }
                                }
                            } else {
                                $max = $default_max_balance;
                            }

                            $reset_date = date('Y-m-d', strtotime('+' . ($times + 1) . ' year', strtotime($join_date)));

                            $balance = LeaveBalance::create([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ]);
                            $balance->max_balance = $max;
                            $balance->reset_date = $reset_date;
                            $balance->save();
                        }
                    } // 按照自然日計算，即下一年的一月一號
                    elseif ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.NATURE_DAY')) {
                        $endDate = new DateTime('first day of next month');
                        $reset_date = $endDate->format('Y-m-d');

                        // cal employee max balance
                        $start = $leave_type->created_at;
                        $now = date('Y-m-d');

                        $ts_start = strtotime($start);
                        $ts_now = strtotime($now);

                        $start_year = date('Y', $ts_start);
                        $now_year = date('Y', $ts_now);

                        $start_month = date('m', $ts_start);
                        $now_month = date('m', $ts_now);

                        $diff = (($now_year - $start_year) * 12) + ($now_month - $start_month);
                        $create_times = $diff;

                        $max = $default_max_balance + $cycle_keep_balance;
                        if ($create_times > 0) {
                            for ($i = 0; $i < $create_times; $i += $cycle_add_each) {
                                if ($max + $cycle_add_day < $cycle_add_max) {
                                    $max += $cycle_add_day;
                                } else {
                                    $max = $cycle_add_max;
                                }
                            }
                        } else {
                            $max = $default_max_balance;
                        }

                        // create employee balance
                        foreach ($employees as $uuid => $join_date) {

                            $balance = LeaveBalance::create([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ]);
                            $balance->max_balance = $max;
                            $balance->reset_date = $reset_date;
                            $balance->save();
                        }
                    }

                }
            }
        } // 年假
        elseif ($leave_type->type == config('constants.LEAVE_TYPE.TYPE.ANNUAL_LEAVE')) {

            //預設起始請假天數
            $default_max_balance = config('constants.LEAVE_TYPE.ANNUAL_LEAVE.DEFAULT_MAX_BALANCE');
            // 每多少年增加一次
            $cycle_add_each = config('constants.LEAVE_TYPE.ANNUAL_LEAVE.CYCLE_ADD_EACH');
            // 每次增加多少假期
            $cycle_add_day = config('constants.LEAVE_TYPE.ANNUAL_LEAVE.CYCLE_ADD_DAY');
            // 最多增加到幾天
            $cycle_add_max = config('constants.LEAVE_TYPE.ANNUAL_LEAVE.CYCLE_ADD_MAX');
            // 可以帶多少天到下一年
            $cycle_keep_balance = config('constants.LEAVE_TYPE.ANNUAL_LEAVE.CYCLE_KEEP_BALANCE');
            // 跳過頭到多少年的累加
            $cycle_add_skip = config('constants.LEAVE_TYPE.ANNUAL_LEAVE.CYCLE_ADD_SKIP');

            if($cycle_keep_balance>0){
                if($cycle_keep_balance>$last_balance){
                    $cycle_keep_balance = $last_balance;
                }
            }

            foreach ($employees as $uuid => $join_date) {
                $join_datetime = new DateTime($join_date);
                $join_date_month = $join_datetime->format('m');

                $now = new DateTime();

                $diff = $now->diff($join_datetime);
                $times = $diff->y;

                $endDate = new DateTime('1st January Next Year');
                $reset_date = $endDate->format('Y-m-d');

                if ($times == 0) {
                    if ($join_date_month > 0 && $join_date_month <= 6) {
                        $times += 1;
                    } else {
                        $balance = LeaveBalance::create([
                            'leave_type_id' => $leave_type->id,
                            'employee_uuid' => $uuid,
                        ]);
                        $balance->max_balance = 0;
                        $balance->reset_date = $reset_date;
                        $balance->save();
                        continue;
                    }
                }elseif ($times == 1){
                    if ($join_date_month > 6 && $join_date_month <= 12) {
                        $times -= 1;
                    }
                }

                $default_max_balance = (int)Employee::find($uuid)->annual_leave;
                $cycle_add_max = $default_max_balance + 7;

                if ($times != 0) {
                    $max = $default_max_balance + $cycle_keep_balance;

                    $skip = $cycle_add_skip;
                    for ($i = 0; $i < $times; $i += $cycle_add_each) {
                        if ($skip > 0) {
                            $skip--;
                        }else{
                            if ($max + $cycle_add_day < $cycle_add_max) {
                                $max += $cycle_add_day;
                            } else {
                                $max = $cycle_add_max;
                                break;
                            }
                        }
                    }
                }else{
                    $max = 0;
                }

                $balance = LeaveBalance::create([
                    'leave_type_id' => $leave_type->id,
                    'employee_uuid' => $uuid,
                ]);
                $balance->max_balance = $max;
                $balance->reset_date = $reset_date;
                $balance->save();

            }
        }// 有薪病假
        elseif ($leave_type->type == config('constants.LEAVE_TYPE.TYPE.PAID_SICK_LEAVE')) {

            //預設起始請假天數
            $default_max_balance = config('constants.LEAVE_TYPE.PAID_SICK_LEAVE.DEFAULT_MAX_BALANCE');
            // 每多少月增加一次
            $cycle_add_each = config('constants.LEAVE_TYPE.PAID_SICK_LEAVE.CYCLE_ADD_EACH');
            // 每次增加多少假期
            $cycle_add_day = config('constants.LEAVE_TYPE.PAID_SICK_LEAVE.CYCLE_ADD_DAY');
            // 最多增加到幾天
            $cycle_add_max = config('constants.LEAVE_TYPE.PAID_SICK_LEAVE.CYCLE_ADD_MAX');
            // 可以帶多少天到下一個月
            $cycle_keep_balance = config('constants.LEAVE_TYPE.PAID_SICK_LEAVE.CYCLE_KEEP_BALANCE');
            // 跳過頭到多少月的累加
            $cycle_add_skip = config('constants.LEAVE_TYPE.PAID_SICK_LEAVE.CYCLE_ADD_SKIP');

            if($cycle_keep_balance>0){
                if($cycle_keep_balance>$last_balance){
                    $cycle_keep_balance = $last_balance;
                }
            }

            foreach ($employees as $uuid => $join_date) {

                // cal employee max balance
                $start = $join_date;
                $now = date('Y-m-d');

                $ts_start = strtotime($start);
                $ts_now = strtotime($now);

                $start_year = date('Y', $ts_start);
                $now_year = date('Y', $ts_now);

                $start_month = date('m', $ts_start);
                $now_month = date('m', $ts_now);

                $diff = (($now_year - $start_year) * 12) + ($now_month - $start_month);
                $times = $diff;

                $max = $default_max_balance;
                if ($times > 12) {
                    $max = 12 * $cycle_add_day;
                    $times -= 12;
                    $max += $times * $cycle_add_day * 2;
                }else{
                    $max = $times * $cycle_add_day;
                }

                if($max>$cycle_add_max){
                    $max = $cycle_add_max;
                }

                $balance = LeaveBalance::create([
                    'leave_type_id' => $leave_type->id,
                    'employee_uuid' => $uuid,
                ]);
                $balance->max_balance = $max;
                $balance->reset_date = null;
                $balance->save();
            }
        }
    }
}
