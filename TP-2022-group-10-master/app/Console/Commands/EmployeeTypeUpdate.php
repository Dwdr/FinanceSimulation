<?php

namespace App\Console\Commands;

use App\Models\EH\Employee;
use App\Traits\EmployeeAuditLog;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class EmployeeTypeUpdate extends Command {

    use EmployeeAuditLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eh:employee_type_change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check employee type change with probation end date.';

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
        $employees = \App\Models\EH\Employee::where('probation_end_date', '<', Carbon::today())
            ->where('type', config('constants.EMPLOYEE.TYPE.TRIAL'))
            ->get();

        Log::info("[Commands] [Employee type change] record find: " . count($employees));

        foreach ($employees as $e) {
            if ($e) {
                $e->type=config('constants.EMPLOYEE.TYPE.REGULAR');
                $data = [
                    'type' => config('constants.EMPLOYEE.TYPE.REGULAR')
                ];
                $this->makeLog($e->uuid,'movement',config('constants.EMPLOYEE_LOG.EVENT.UPDATED'),$data,'','Probation end date effective.');
                $e->save();
                Log::info("[Commands] [Employee type change] record updated: " . $e->uuid);
            }
        }
    }
}
