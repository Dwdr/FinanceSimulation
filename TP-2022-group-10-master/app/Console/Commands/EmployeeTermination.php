<?php

namespace App\Console\Commands;

use App\Models\Auth\User;
use App\Models\EH\Employee;
use App\Traits\EmployeeAuditLog;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmployeeTermination extends Command {

    use EmployeeAuditLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eh:employee_termination';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check and effective employee termination';

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
        $terminations = \App\Models\EH\Employee\EmployeeLog::where('type',config('constants.EMPLOYEE_LOG.TYPE.CAREER'))
            ->where('event', config('constants.EMPLOYEE_LOG.EVENT.DELETED'))
            ->where('effective_type', config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.SELECT_DATE'))
            ->where('effective_date', '<=', Carbon::today())
            ->where('status', config('constants.EMPLOYEE_LOG.STATUS.PENDING'))
            ->get();

        Log::info("[Commands] [Employee termination effective] record find: " . count($terminations));

        foreach ($terminations as $t) {
            $e = Employee::find($t->employee_uuid);
            if ($e) {
                $t->status=config('constants.EMPLOYEE_LOG.STATUS.APPROVED_UPDATED');
                $this->makeLog($e->uuid,'termination',config('constants.EMPLOYEE_LOG.EVENT.DELETED'),[],$t->creator_id);
                $u = User::findOrFail($e->user_id);
                $u->active = false;
                $u->save();
                $e->type = config('constants.EMPLOYEE.TYPE.RESIGNED');
                $e->save();
            }
            $t->save();
            Log::info("[Commands] [Employee movement effective] record updated: " . $e->uuid);
        }
    }
}
