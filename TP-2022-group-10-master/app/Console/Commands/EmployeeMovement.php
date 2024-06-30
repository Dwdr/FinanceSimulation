<?php

namespace App\Console\Commands;

use App\Models\EH\Employee;
use App\Traits\EmployeeAuditLog;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class EmployeeMovement extends Command {

    use EmployeeAuditLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eh:employee_movement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check and effective employee movement change';

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
        $movements = \App\Models\EH\Employee\EmployeeLog::where('type',config('constants.EMPLOYEE_LOG.TYPE.CAREER'))
            ->where('event', config('constants.EMPLOYEE_LOG.EVENT.UPDATED'))
            ->where('effective_type', config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.SELECT_DATE'))
            ->where('effective_date', '<=', Carbon::today())
            ->where('status', config('constants.EMPLOYEE_LOG.STATUS.PENDING'))
            ->get();

        Log::info("[Commands] [Employee movement effective] record find: " . count($movements));

        foreach ($movements as $m) {
            $e = Employee::find($m->employee_uuid);
            if ($e) {
                // add employee CRUD log
                $this->makeLog($e->uuid,'movement',config('constants.EMPLOYEE_LOG.EVENT.UPDATED'),$m->updated_data);
                foreach ($m->updated_data as $key => $value) {
                    if ($e->{$key} != $value) {
                        $e->{$key} = $value;
                    }
                }
                $e->save();
            }
            // update movement status
            $m->status = config('constants.EMPLOYEE_LOG.STATUS.APPROVED_UPDATED');
            $m->save();
            Log::info("[Commands] [Employee movement effective] record updated: " . $e->uuid);
        }
    }
}
