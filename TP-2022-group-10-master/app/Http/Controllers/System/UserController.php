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

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Auth\UserOAuth;
use App\Models\Auth\UserProfile;
use App\Models\EH\Employee;
use App\Models\EH\Employee\EmployeeMovement;
use App\Models\EH\Employee\EmployeePersonnelChange;
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller {

    private $mode = [
        'isModeShow' => false,
        'isModeCreate' => false,
        'isModeEdit' => false,
    ];

    private $msg_auth_reject = "You are not authorized for the module";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (!auth()->user()->can('system.user.r')) {
            session()->flash('alert-warning', "You are not authorized for the module \"User\". ");
            return redirect()->route('dashboard.index');
        }
        $users = User::with('roles')->get();
        return view('system.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // todo Role select

        $this->mode['isModeCreate'] = true;
        return view('system.user.detail')->with('mode', $this->mode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:sys_users',
            'password' => 'required|min:8|string',
            'dob' => 'date',
        ]);
        $u = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $up = new UserProfile;
        $up->user_id = $u->id;
        $up->name = $request->name;
        $up->avatar_id = $request->avatar_id;
        $up->contacts = $request->contacts;
        $up->address = $request->address;
        $up->dob = $request->dob;
        $up->status = $request->status == 'on';
        $up->save();

        session()->flash('alert-success', "User created.");
        return redirect()->route('system.user.show', $u->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $this->mode['isModeShow'] = true;
        $u = User::with('roles', 'roles.permissions')->find($id);
        return view('system.user.detail', compact('u'))->with('mode', $this->mode);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $this->mode['isModeEdit'] = true;
        $u = User::find($id);
        return view('system.user.detail', compact('u'))->with('mode', $this->mode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:sys_users,email,' . $id,
            'dob' => 'date',
        ]);
        $u = User::find($id);
        $u->email = $request->email;
        $u->save();

        $up = UserProfile::find($u->profile->id);
        $up->name = $request->name;
        $up->avatar_id = $request->avatar_id;
        $up->contacts = $request->contacts;
        $up->address = $request->address;
        $up->dob = $request->dob;
        $up->status = $request->status == 'on';
        $up->save();

        session()->flash('alert-success', "User updated.");
        return redirect()->route('system.user.show', $u->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $u = User::find($id);
        $u->delete();
        session()->flash('alert-success', "User deleted.");
        return redirect()->route('system.user.index');
    }


    /***************************************
     *
     *  User Profile
     *
     ***************************************/


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function profile() {
        $this->mode['isModeShow'] = true;
        $u = User::find(Auth::user()->id);
        $oauth = [];
        foreach ($u->oauth as $o) {
            $oauth[$o->provider] = true;
        }
        return view('ssc.profile.index', compact('u', 'oauth'))->with('mode', $this->mode);
    }

    public function profile_edit() {
        $this->mode['isModeEdit'] = true;
        $u = User::find(Auth::user()->id);
        return view('ssc.profile.index', compact('u'))->with('mode', $this->mode);
    }

    public function profile_update(Request $request) {
        $user = Auth::user();
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'dob' => 'date|nullable',
        ]);

        $up = UserProfile::find($user->profile->id);
        $up->name = $request->name;
        $up->avatar_id = $request->avatar_id;
        $up->contacts = $request->contacts;
        $up->address = $request->address;
        $up->dob = $request->dob;
        $up->save();

        session()->flash('alert-success', "Profile updated.");
        return redirect()->route('profile.index');
    }

    public function password() {
        switch (Auth::user()->getRoleNames()[0]){
            case (config('constants.ROLE.ADMIN')):
                return view('system.user.password');
            case (config('constants.ROLE.USER')):
                return view('ssc.system.change_password');
        }
     }

    /**
     * Update Student Password
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePassword(Request $request) {

        //function config
        $route_reject="eh.dashboard.index";
        $route_accept="login";
        $auth=config("constants.PERMISSION.ACCOUNT-U");
        $msg_update_success="Password changed, please re-login.";

        //check authorization
        if (!auth()->user()->can($auth)) {
            //authorization reject
            //show warning
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to reject page
            return redirect()->route($route_reject);
        }else{
            $id = Auth::user()->id;
            $u = User::find($id);

            $this->validate($request, [
                'password' => 'required|string|min:8|different:old_password|confirmed',
                'old_password' => 'required',
            ]);

            if (Hash::check($request->old_password, $u->password)) {
                $u->password = Hash::make($request->password);
                $u->save();

                Auth::logout();
                session()->flash('alert-success', $msg_update_success);
                return redirect()->route($route_accept);
            } else {
                session()->flash('alert-danger', "The current password is not entered correctly.");
                return redirect()->route('profile.password.index');
            }

        }
    }

    /***************************************
     *
     *  Employee Profile
     *
     ***************************************/

    public function employee(){
        if (!auth()->user()->can('account.r')) {
            session()->flash('alert-warning', "You are not authorized for the module \"Profile\". ");
            return redirect()->route('dashboard.index');
        }

        if (Auth::user()->hasRole(config('constants.ROLE.SUPER_ADMIN'))) {
            session()->flash('alert-warning', "Super Admin not \"Profile\" record. ");
            return redirect()->route('dashboard.index');
        }

        $this->mode['isModeShow'] = true;
        $u = User::with('employee')->find(Auth::user()->id);

//        $genders = Gender::where('is_active', true)->get();
//        $martial_status = MartialStatus::where('is_active', true)->get();
//        $nationalities = Nationality::where('is_active', true)->get();
//        $titles = Title::where('is_active', true)->get();
//        $departments = Department::where('is_active', true)->get();
//        $designations = Designation::where('is_active', true)->get();
//        $relationships = Relationship::where('is_active', true)->get();
//        $employee_types = EmployeeType::where('is_active', true)->get();
//        $banks = Bank::where('is_active', true)->get();
//        $grades = Grade::where('is_active', true)->get();
//        $highest_educations = HighestEducation::where('is_active', true)->get();
//        $employees = Employee::all();
//        return view('system.user.employee', compact('u','genders','martial_status','nationalities','titles','departments','designations','relationships','employee_types','banks','grades','highest_educations','employees'))->with('mode', $this->mode);
        return view('system.user.employee', compact('u'))->with('mode', $this->mode);
    }

    public function employee_change(){
        if (!auth()->user()->can('account.u')) {
            session()->flash('alert-warning', "You are not authorized for the module \"Profile\". ");
            return redirect()->route('dashboard.index');
        }

        if (Auth::user()->hasRole(config('constants.ROLE.SUPER_ADMIN'))) {
            session()->flash('alert-warning', "Super Admin not \"Profile\" record. ");
            return redirect()->route('dashboard.index');
        }

        $this->mode['isModeEdit'] = true;
        $u = User::with('employee')->find(Auth::user()->id);

        $genders = Gender::where('is_active', true)->get();
        $martial_status = MartialStatus::where('is_active', true)->get();
        $nationalities = Nationality::where('is_active', true)->get();
        $titles = Title::where('is_active', true)->get();
        $relationships = Relationship::where('is_active', true)->get();
        $banks = Bank::where('is_active', true)->get();
        $highest_educations = HighestEducation::where('is_active', true)->get();
        return view('system.user.employee_edit', compact('u','genders','martial_status','nationalities','titles','relationships','banks','highest_educations'))->with('mode', $this->mode);
    }

    /**
     * Store the input value inputted from create page
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function employee_submit(Request $request) {
        //function config
        $route_reject = "eh.dashboard.index";
        $route_accept = "account.index";
        $auth = config("constants.PERMISSION.ACCOUNT-U");
        $msg_store_success = "Personnel Change form created.";
        $msg_store_no_change = "Employee record no any change.";

        if (Auth::user()->hasRole(config('constants.ROLE.SUPER_ADMIN'))) {
            session()->flash('alert-warning', "Super Admin not \"Profile\" record. ");
            return redirect()->route('dashboard.index');
        }

        //check authorization
        if (!auth()->user()->can($auth)) {
            //authorization reject
            //show warning
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to reject page
            return redirect()->route($route_reject);
        } else {
            //if authorization accept
            $request->validate([
                'effective_type' => 'required',
                'first_name' => 'required',
                'last_name' => 'required'
            ]);
            $data = $request->all();
            $data['status']=config('constants.EMPLOYEE.MOVEMENT_STATUS.PENDING');


            $e = Auth::user()->employee;

            $original_data = [];
            $change_data = [];
            $count = 0;

            foreach ($data as $key => $value){
                switch($key){
                    case 'effective_type':
                    case 'effective_date':
                    case 'remarks':
                    case 'status':
                    case '_token':
                        continue 2;
                }
                if($e->{$key}!=$value){
                    $original_data[$key] = $e->{$key};
                    $change_data[$key] = $value;
                    $count++;

                    if($data['effective_type']==1){
                        $e->{$key} = $value;
                    }
                }
            }
            if($count == 0){
                session()->flash('fail', $msg_store_no_change);
                return redirect()->back()->withInput();
            }else{
                if($data['effective_type']==1){
                    $data['effective_date']=date('Y-m-d');
                }
            }

            $data['uuid'] = Str::uuid();
            $data['employee_uuid'] = $e->uuid;
            $data['organization_id'] = Auth::user()->employee->organization_id;
            $data['creator_id'] = Auth::user()->id;
            $data['original_data'] = serialize($original_data);
            $data['change_data'] = serialize($change_data);
            $ep = EmployeePersonnelChange::create($data);

            // TODO add log
            //  add task schedule.

            session()->flash('message', $msg_store_success);
            return redirect()->route($route_accept);
        }
    }

}
