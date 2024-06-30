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

namespace App\Http\Controllers\EH\SystemSettings;

use App\Models\Auth\Organization;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Auth\UserProfile;
use App\Models\EH\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CompanyController extends Controller{

    /**
     * Classified the detail blade view into 4 modes
     * isModeShow, isModeCreate, isModeClone, and isModeEdit
     *
     * @return void
     */
    private $mode=[
        'isModeShow'=>false,
        'isModeCreate'=>false,
        'isModeEdit'=>false,
        'isModeClone'=>false,
    ];
    private $msg_auth_reject="You are not authorized for the module";
    private $validation_rules=[
        'name'=>'required',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the index page (list view) for the function.
     *
     * @return RedirectResponse
     * @return View
     */
    public function index(){
        //function config
        $route_reject="eh.dashboard.index";
        $view_accept="eh.system_settings.company.index";
        $auth=config("constants.PERMISSION.EH-SETTINGS-COMPANY-R");

        //check authorization
        if (!auth()->user()->can($auth)) {
            //authorization reject
            //show warning
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to reject page
            return redirect()->route($route_reject);
        }else{
            //authorization accept
            if(!Auth::user()->hasRole(config('constants.ROLE.SUPER_ADMIN'))){
                abort(404);
            }
            $company = Organization::all();
            return view($view_accept, compact('company'));
        }
    }

    /**
     * Show the create page for the function.
     *
     * @return RedirectResponse
     * @return View
     */
    public function create(){
        //function config
        $route_reject="eh.dashboard.index";
        $view_accept="eh.system_settings.company.detail";
        $auth=config("constants.PERMISSION.EH-SETTINGS-COMPANY-C");
        $this->mode['isModeCreate']=true;

        //check authorization
        if (!auth()->user()->can($auth)) {
            //if authorization reject
            //show warning
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to reject page
            return redirect()->route($route_reject);
        }else{
            //if authorization accept
            if(!Auth::user()->hasRole(config('constants.ROLE.SUPER_ADMIN'))){
                abort(404);
            }

            return view($view_accept)->with('mode',$this->mode);
        }
    }

    /**
     * Store the input value inputted from create page
     *
     * @param  Request   $request
     *
     * @return RedirectResponse
     * @return RedirectResponse
     */
    public function store(Request $request){
        //function config
        $route_reject="eh.dashboard.index";
        $route_accept="eh.system_settings.company.show";
        $auth=config("constants.PERMISSION.EH-SETTINGS-COMPANY-C");
        $msg_store_success="Organization created.";

        //check authorization
        if (!auth()->user()->can($auth)) {
            //authorization reject
            //show warning
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to reject page
            return redirect()->route($route_reject);
        }else{
            //if authorization accept
            if(!Auth::user()->hasRole(config('constants.ROLE.SUPER_ADMIN'))){
                abort(404);
            }

            $request->validate($this->validation_rules);
            $data = $request->all();


            $data['default'] = serialize($request->default);
            $data['name_slug'] = Str::slug($request->name);
            $company = Organization::create($data);

            $password = Hash::make('1L0veRMB!');
            $account = User::create([
                'password' => $password,
                'email' => $request->config['contact_email'],
            ]);

            //Admin - Create Profile
            $profile = UserProfile::create([
                'user_id' => $account->id,
                'organization_id' => $company->id,
                'name' => 'Admin',
                'status'=>true,
            ]);
            $employee = Employee::create([
                'uuid' => Str::uuid(),
                'organization_id' => $company->id,
                'creator_id' => Auth::user()->id,
                'employee_id' => 'A00001',
                'user_id' => $account->id,
                'email' => $account->email,
                'first_name' => 'System',
                'last_name' => 'Admin',
                'hkid_image' =>serialize([]),
                'bank_card_image' =>serialize([]),
                'support_documents' =>serialize([]),
            ]);
            $account->assignRole(config('constants.ROLE.ADMIN'));

            $company->owner_id = Auth::user()->profile->organization_id;
            $company->save();

            session()->flash('message', $msg_store_success);
            return redirect()->route($route_accept, $company->id);
        }
    }

    /**
     * Show the selected entry record by key-in the primary ID
     *
     * @param int $id
     *
     * @return RedirectResponse
     * @return View
     */
    public function show($id){
        //function config
        $route_reject="eh.dashboard.index";
        $view_accept="eh.system_settings.company.detail";
        $auth=config("constants.PERMISSION.EH-SETTINGS-COMPANY-R");
        $this->mode['isModeShow']=true;

        //check authorization
        if (!auth()->user()->can($auth)) {
            //authorization reject
            //show warning
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to reject page
            return redirect()->route($route_reject);
        }else{
            //authorization accept
            //check if the record showing is belongs to the user
            //TODO we should check if the record showing is belongs to the user
            $c = Organization::findOrFail($id);
            return view($view_accept, compact('c'))->with('mode',$this->mode);
        }
    }


    /**
     * Show the edit page for the selected record.
     *
     * @param  integer   $id
     *
     * @return RedirectResponse
     * @return View
     */
    public function edit($id){
        //function config
        $route_reject="eh.dashboard.index";
        $view_accept="eh.system_settings.company.detail";
        $auth=config("constants.PERMISSION.EH-SETTINGS-COMPANY-U");
        $this->mode['isModeEdit']=true;

        //check authorization
        if (!auth()->user()->can($auth)) {
            //if authorization reject
            //show warning
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to reject page
            return redirect()->route($route_reject);
        }else{
            //authorization accept
            //check if the record editing is belongs to the user
            //TODO we should check if the record editing is belongs to the user
            $c = Organization::findOrFail($id);
            return view($view_accept,compact('c'))->with('mode',$this->mode);
        }
    }

    /**
     * Update the input value inputted from create page
     *
     * @param  Request   $request
     * @param  Organization   $company
     *
     * @return RedirectResponse
     * @return RedirectResponse
     */
    public function update(Request $request, Organization $company){
        //function config
        $route_reject="eh.dashboard.index";
        $route_accept="eh.system_settings.company.show";
        $auth=config("constants.PERMISSION.EH-SETTINGS-COMPANY-U");
        $msg_update_success="Organization updated.";

        //check authorization
        if (!auth()->user()->can($auth)) {
            //authorization reject
            //show warning
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to reject page
            return redirect()->route($route_reject);
        }else{
            //authorization accept
            //check if the record deleting is belongs to the user
            //TODO we should check if the record deleting is belongs to the user
            $request->validate($this->validation_rules);
            $data = $request->all();
            $data['name_slug'] = Str::slug($request->name);
            $data['default'] = serialize($request->default);
            $company->update($data);
            session()->flash('message', $msg_update_success);
            return redirect()->route($route_accept, $company->id);
        }
    }

    /**
     * Delete the input value inputted from create page
     *
     * @param  Organization   $company
     * @return RedirectResponse
     */
    public function destroy(Organization $company){
        //function config
        $route_reject="eh.dashboard.index";
        $route_accept="eh.system_settings.company.index";
        $auth=config("constants.PERMISSION.EH-SETTINGS-COMPANY-D");
        $msg_destroy_success="Organization deleted.";

        //check authorization
        if (!auth()->user()->can($auth)) {
            //show warning message: authorization not match
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to dashboard if authorization not match
            return redirect()->route($route_reject);
        }else{
            //authorization accept
            if(!Auth::user()->hasRole(config('constants.ROLE.SUPER_ADMIN'))){
                abort(404);
            }
            //check if the record deleting is belongs to the user
            //TODO we should check if the record deleting is belongs to the user
            $company->delete();
            session()->flash('message', $msg_destroy_success);
            return redirect()->route($route_accept);
        }
    }
}
