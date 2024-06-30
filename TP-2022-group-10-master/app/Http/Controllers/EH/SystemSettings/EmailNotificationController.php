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
use App\Models\EH\SystemSettings\EmailTemplateType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class EmailNotificationController extends Controller{

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
     * Show the selected entry record by key-in the primary ID
     *
     * @param int $id
     *
     * @return RedirectResponse
     * @return View
     */
    public function show($id){
        $types = EmailTemplateType::getConstants();
        $this->mode['isModeShow']=true;

        if($id != Auth::user()->profile->organization_id){
            abort(404);
        }
        $c = Organization::findOrFail($id);

        return view("eh.system_settings.email_notification.detail", compact('c', 'types'))->with('mode',$this->mode);
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
        $types = EmailTemplateType::getConstants();
        $this->mode['isModeEdit']=true;

        if($id != Auth::user()->profile->organization_id){
            abort(404);
        }
        $c = Organization::findOrFail($id);
        return view("eh.system_settings.email_notification.detail",compact('c','types'))->with('mode',$this->mode);
    }

    /**
     * Update the input value inputted from create page
     *
     * @param Request $request
     * @param Organization $company
     * @return RedirectResponse
     */
    public function update(Request $request, $id){
        $msg_update_success="Email notification updated.";

        $request->validate($this->validation_rules);
        $data = $request->all();

        if($id != Auth::user()->profile->organization_id){
            abort(404);
        }

        $c = Organization::findOrFail($id);
        foreach (config('constants.EMAIL-TYPE') as $key => $value){
            if($value == EmailTemplateType::MSG_JA_0005){
                continue;
            }
            $email_notification[$value]['admin']=(isset($data['email_notification'][$value]['admin']) && $data['email_notification'][$value]['admin'] == 'on');
            $email_notification[$value]['employee']=(isset($data['email_notification'][$value]['employee']) && $data['email_notification'][$value]['employee'] == 'on');
        }

        $c->email_notification = serialize($email_notification);
        $c->save();
        session()->flash('message', $msg_update_success);
        return redirect()->route("eh.system_settings.email_notification.show", $c->id);
    }

}
