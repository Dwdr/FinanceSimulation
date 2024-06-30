<?php

namespace App\Console\Commands;

use App\Models\EH\Employee;
use App\Traits\EmployeeAuditLog;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class EmployeePersonnelChange extends Command {

    use EmployeeAuditLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eh:employee_personnel_change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check and effective employee personnel change';

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
        $personnel = \App\Models\EH\Employee\EmployeeLog::where('type',config('constants.EMPLOYEE_LOG.TYPE.PERSONAL'))
            ->where('event', config('constants.EMPLOYEE_LOG.EVENT.UPDATED'))
            ->where('effective_type', config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.SELECT_DATE'))
            ->where('effective_date', '<=', Carbon::today())
            ->where('status', config('constants.EMPLOYEE_LOG.STATUS.APPROVED'))
            ->get();

        Log::info("[Commands] [Employee personnel change effective] record find: " . count($personnel));

        foreach ($personnel as $p) {
            $e = Employee::find($p->employee_uuid);
            if ($e) {
                $this->makeLog($e->uuid,'personal',config('constants.EMPLOYEE_LOG.EVENT.UPDATED'),$p->updated_data);
                foreach ($p->updated_data as $key => $value) {
                    if ($e->{$key} != $value) {
                        $e->{$key} = $value;
                    }
                }
                $e->save();
            }
            $p->status = config('constants.EMPLOYEE_LOG.STATUS.APPROVED_UPDATED');
            $p->save();
            Log::info("[Commands] [Employee movement effective] record updated: " . $e->uuid);
        }
    }
}
