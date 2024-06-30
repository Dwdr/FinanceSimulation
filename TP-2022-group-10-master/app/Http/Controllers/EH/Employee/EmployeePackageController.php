<?php
/*
 * Kamphora CONFIDENTIAL
 * Copyright (c) 2020.
 * ------------------------------------
 * [2002] - [2020] Kamphora Limited (Hong Kong)
 *  All Rights Reserved.
 *
 *  NOTICE:  All information contained herein is, and remains
 *  the property of Kamphora Limited (Hong Kong) and its affiliated parties,
 *  if any. The intellectual and technical concepts contained
 *  herein are proprietary to Kamphora Limited (Hong Kong)
 *  and its affiliated parties and may be covered by U.S. and Foreign Patents,
 *  patents in process, and are protected by trade secret or copyright law.
 *  Dissemination of this information or reproduction of this material
 *  is strictly forbidden unless prior written permission is obtained
 *  from Kamphora Limited (Hong Kong).
 *
 *  This file is subject to the terms and conditions defined in
 *  file 'LICENSE.txt', which is part of this source code package.
 *
 *  Should you require any further information,
 *  please contact info@Kamphora.com
 */

namespace App\Http\Controllers\EH\Employee;

use App\Models\Auth\Organization;
use App\Models\Auth\User;
use App\Models\Auth\UserProfile;
use App\Models\EH\Employee;
use App\Http\Controllers\Controller;
use App\Models\EH\Employee\EmployeeLog;
use App\Models\EH\Employee\EmployeeMovement;
use App\Models\EH\Configurations\Bank;
use App\Models\EH\Configurations\Department;
use App\Models\EH\Configurations\Designation;
use App\Models\EH\Configurations\EmployeeType;
use App\Models\EH\Configurations\Gender;
use App\Models\EH\Configurations\Grade;
use App\Models\EH\Configurations\HighestEducation;
use App\Models\EH\Configurations\MartialStatus;
use App\Models\EH\Configurations\Nationality;
use App\Models\EH\Configurations\Relationship;
use App\Models\EH\Configurations\Title;
use App\Traits\EmployeeAuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use phpDocumentor\Reflection\Type;
use Vinkla\Hashids\Facades\Hashids;

class EmployeePackageController extends Controller {

    use EmployeeAuditLog;

    /**
     * Classified the detail blade view into 4 modes
     * isModeShow, isModeCreate, isModeClone, and isModeEdit
     *
     * @return void
     */
    private $mode = [
        'isModeShow' => false,
        'isModeCreate' => false,
        'isModeEdit' => false,
        'isModeClone' => false,
    ];
    private $msg_auth_reject = "You are not authorized for the module";
    private $validation_rules = [
        // TODO
        'effective_type' => 'required',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Show the index page (list view) for the function.
     *
     * @return RedirectResponse
     * @return View
     */
    public function index($uuid) {
        //function config
        $route_reject = "eh.dashboard.index";
        $auth = config("constants.PERMISSION.EH-EMPLOYEE-R");

        //check authorization
        if (!auth()->user()->can($auth)) {
            //authorization reject
            //show warning
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to reject page
            return redirect()->route($route_reject);
        } else {
            //authorization accept
//            $e = Employee::findOrFail($uuid);
//            return view($view_accept, compact('e'));
            return redirect()->route('eh.employee.show',['employee'=>$uuid,'tab'=>'package']);
        }
    }

    /**
     * Show the create page for the function.
     *
     * @return RedirectResponse
     * @return View
     */
    public function create($uuid) {
        //function config
        $route_reject = "eh.dashboard.index";
        $view_accept = "eh.employee.package.detail";
        $auth = config("constants.PERMISSION.EH-EMPLOYEE-PACKAGE-C");
        $this->mode['isModeCreate'] = true;

        //check authorization
        if (!auth()->user()->can($auth)) {
            //if authorization reject
            //show warning
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to reject page
            return redirect()->route($route_reject);
        } else {
            //if authorization accept

            $e = Employee::findOrFail($uuid);
            $p = $e->package[0];
            return view($view_accept, compact('e','p'))->with('mode', $this->mode);
        }
    }

    /**
     * Store the input value inputted from create page
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request, $uuid) {
        //function config
        $route_reject = "eh.dashboard.index";
        $route_accept = "eh.employee.package.show";
        $auth = config("constants.PERMISSION.EH-EMPLOYEE-PACKAGE-C");
        $msg_store_success = "Employee package created.";

        //check authorization
        if (!auth()->user()->can($auth)) {
            //authorization reject
            //show warning
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to reject page
            return redirect()->route($route_reject);
        } else {
            //if authorization accept
            $request->validate($this->validation_rules);
            $data = $request->all();

            $e = Employee::findOrFail($uuid);

            $data['organization_id'] = Auth::user()->profile->organization_id;
            $data['creator_id'] = Auth::user()->id;
            $data['employee_uuid'] = $e->uuid;
            if($data['effective_type'] == config('constants.EMPLOYEE_LOG.EFFECTIVE_TYPE.NOW')){
                $data['effective_date']=date('Y-m-d');
                $data['status'] = config('constants.EMPLOYEE_LOG.STATUS.APPROVED_UPDATED');
            }else{
                $data['status'] = config('constants.EMPLOYEE_LOG.STATUS.PENDING');
            }

            $data['type'] = config('constants.EMPLOYEE_LOG.TYPE.PACKAGE');
            $data['event'] = config('constants.EMPLOYEE_LOG.EVENT.UPDATED');
            $data['source'] = 'employee package';
            $data['original_data'] = serialize([]);
            $data['updated_data'] = serialize([]);
            $data['detail'] = serialize($data['detail']);
            $el = EmployeeLog::create($data);

            session()->flash('message', $msg_store_success);
            return redirect()->route($route_accept, ['uuid' => $uuid, 'hash_id' => $el->hash_id]);
        }
    }

    /**
     * Show the selected entry record by key-in the primary ID
     *
     * @param uuid $uuid
     *
     * @return RedirectResponse
     * @return View
     */
    public function show($uuid, $hash_id) {
        //function config
        $route_reject = "eh.dashboard.index";
        $view_accept = "eh.employee.package.detail";
        $auth = config("constants.PERMISSION.EH-EMPLOYEE-PACKAGE-R");
        $this->mode['isModeShow'] = true;

        //check authorization
        if (!auth()->user()->can($auth)) {
            //authorization reject
            //show warning
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to reject page
            return redirect()->route($route_reject);
        } else {
            //authorization accept
            //check if the record showing is belongs to the user
            //TODO we should check if the record showing is belongs to the user
            $e = Employee::findOrFail($uuid);
            $p = EmployeeLog::where('hash_id',$hash_id)
                ->where('type',config('constants.EMPLOYEE_LOG.TYPE.PACKAGE'))
                ->where('event',config('constants.EMPLOYEE_LOG.EVENT.UPDATED'))
                ->first();
            if(!$p){
                abort(404);
            }
            return view($view_accept, compact('e', 'p'))->with('mode', $this->mode);

        }
    }

    /**
     * Delete the input value inputted from create page
     *
     * @param Employee $e
     * @return RedirectResponse
     */
    public function destroy($uuid, $hash_id) {
        //function config
        $route_reject = "eh.dashboard.index";
        $route_accept = "eh.employee.package.index";
        $auth = config('constants.PERMISSION.EH-EMPLOYEE-PACKAGE-D');
        $msg_destroy_success = "Employee package record deleted.";

        //check authorization
        if (!auth()->user()->can($auth)) {
            //show warning message: authorization not match
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to dashboard if authorization not match
            return redirect()->route($route_reject);
        } else {
            //authorization accept
            $p = EmployeeLog::where('hash_id',$hash_id)
                ->where('type',config('constants.EMPLOYEE_LOG.TYPE.PACKAGE'))
                ->where('event',config('constants.EMPLOYEE_LOG.EVENT.UPDATED'))
                ->first();
            if(!$p){
                abort(404);
            }
            $p->status = config('constants.EMPLOYEE_LOG.STATUS.CANCELED');
            $p->save();
            $p->delete();
            session()->flash('message', $msg_destroy_success);
            return redirect()->route($route_accept, $uuid);
        }
    }

}
