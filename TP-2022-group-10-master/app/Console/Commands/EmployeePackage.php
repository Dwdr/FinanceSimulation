<?php

namespace App\Console\Commands;

use App\Models\EH\Employee;
use App\Traits\EmployeeAuditLog;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class EmployeePackage extends Command {

    use EmployeeAuditLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eh:employee_package';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check and effective employee package';

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
        $packages = \App\Models\EH\Employee\EmployeeLog::where('type',config('constants.EMPLOYEE_LOG.TYPE.PACKAGE'))
            ->where('event', config('constants.EMPLOYEE_LOG.EVENT.UPDATED'))
            ->where('effective_type', config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.SELECT_DATE'))
            ->where('effective_date', '<=', Carbon::today())
            ->where('status', config('constants.EMPLOYEE_LOG.STATUS.PENDING'))
            ->get();

        Log::info("[Commands] [Employee package effective] record find: " . count($packages));

        foreach ($packages as $p) {
            $e = Employee::find($p->employee_uuid);
            // update movement status
            $p->status = config('constants.EMPLOYEE_LOG.STATUS.APPROVED_UPDATED');
            $p->save();
            Log::info("[Commands] [Employee movement effective] record updated: " . $e->uuid);
        }
    }
}
