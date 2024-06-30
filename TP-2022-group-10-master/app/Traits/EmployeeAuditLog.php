<?php

namespace App\Traits;

use App\Models\Auth\User;
use App\Models\EH\Employee;
use App\Models\EH\Employee\EmployeeLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

trait EmployeeAuditLog {

    public function makeLog($e_uuid, $source, $event, $updated_data = [], $creator_id = "", $description = "") {
        $type = config('constants.EMPLOYEE_LOG.TYPE.LOG');
        $e = Employee::find($e_uuid);
        if ($e) {
            $original_data = $e->toArray();
            unset($updated_data['_method']);
            unset($updated_data['_token']);
            unset($updated_data['edit_reason']);
            unset($original_data['uuid']);
            unset($original_data['user_id']);
            unset($original_data['created_at']);
            unset($original_data['updated_at']);

            if($creator_id == ""){
                if(Auth::check()){
                    $creator_id = Auth::user()->id;
                }else{
                    //System super admin
                    $creator_id = User::find(1)->id;
                }
            }

            if ($event == config('constants.EMPLOYEE_LOG.EVENT.CREATED')) {
                EmployeeLog::create([
                    'employee_uuid' => $e_uuid,
                    'organization_id' => $e->organization_id,
                    'creator_id' => $creator_id,
                    'type' => $type,
                    'event' => $event,
                    'source' => $source,
                    'original_data' => serialize([]),
                    'updated_data' => serialize($original_data),
                    'description' => $description,
                    'effective_type' => config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.NA'),
                    'status' => config('constants.EMPLOYEE_LOG.STATUS.NA'),
                ]);
            } else {
                if ($event == config('constants.EMPLOYEE_LOG.EVENT.DELETED')) {
                    EmployeeLog::create([
                        'employee_uuid' => $e_uuid,
                        'organization_id' => $e->organization_id,
                        'creator_id' => $creator_id,
                        'type' => $type,
                        'event' => $event,
                        'source' => $source,
                        'original_data' => serialize($original_data),
                        'updated_data' => serialize([]),
                        'description' => $description,
                        'effective_type' => config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.NA'),
                        'status' => config('constants.EMPLOYEE_LOG.STATUS.NA'),
                    ]);
                }else{
                    // updated
                    // termination
                    EmployeeLog::create([
                        'employee_uuid' => $e_uuid,
                        'organization_id' => $e->organization_id,
                        'creator_id' => $creator_id,
                        'type' => $type,
                        'event' => $event,
                        'source' => $source,
                        'original_data' => serialize($original_data),
                        'updated_data' => serialize($updated_data),
                        'description' => $description,
                        'effective_type' => config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.NA'),
                        'status' => config('constants.EMPLOYEE_LOG.STATUS.NA'),
                    ]);
                }
            }
        }
    }

}
