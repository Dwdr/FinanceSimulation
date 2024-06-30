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

use App\Models\EH\Configurations\Bank;
use App\Http\Controllers\Controller;
use App\Models\EH\SystemSettings\EmailTemplate;
use App\Models\EH\SystemSettings\EmailTemplateType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class EmailTemplateController extends Controller{

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
        'subject'=>'required',
        'body'=>'required',
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
        $types = EmailTemplateType::getConstants();
        return view("eh.system_settings.email_template.index", compact('types'));
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
        $this->mode['isModeShow']=true;

        foreach (config('constants.EMAIL-TYPE') as $key => $value){
            if($value == $id){
                if (view()->exists('emails.default_template.eh.' . $key)){
                    $body = \view('emails.default_template.eh.' . $key)->render();
                }else{
                    $body = $key.' email template.';
                }
                $template = EmailTemplate::firstOrCreate([
                    'organization_id' => Auth::user()->profile->organization_id,
                    'type' => $id,
                ],[
                    'uuid' => Str::uuid(),
                    'subject' => '['.Auth::user()->profile->organization->name.'] '.$key .' Notification',
                    'body' => $body
                ]);
                return view("eh.system_settings.email_template.detail", compact('template'))->with('mode',$this->mode);
            }
        }
        abort(404);
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
        $this->mode['isModeEdit']=true;

        foreach (config('constants.EMAIL-TYPE') as $key => $value){
            if($value == $id){
                if (view()->exists('emails.default_template.eh.' . $key)){
                    $body = \view('emails.default_template.eh.' . $key)->render();
                }else{
                    $body = $key.' email template.';
                }
                $template = EmailTemplate::firstOrCreate([
                    'organization_id' => Auth::user()->profile->organization_id,
                    'type' => $id,
                ],[
                    'uuid' => Str::uuid(),
                    'subject' => '['.Auth::user()->profile->organization->name.'] '.$key .' Notification',
                    'body' => $body
                ]);
                return view("eh.system_settings.email_template.detail", compact('template'))->with('mode',$this->mode);
            }
        }
        abort(404);
    }

    /**
     * Update the input value inputted from create page
     *
     * @param  Request   $request
     * @param  Bank   $email_template
     *
     * @return RedirectResponse
     * @return RedirectResponse
     */
    public function update(Request $request,$id){
        $msg_update_success="Email Template updated.";
        $request->validate($this->validation_rules);
        $data = $request->all();
        foreach (config('constants.EMAIL-TYPE') as $key => $value){
            if($value == $id){
                $template = EmailTemplate::firstOrCreate([
                    'organization_id' => Auth::user()->profile->organization_id,
                    'type' => $id,
                ],[
                    'uuid' => Str::uuid(),
                    'subject' => $data['subject'],
                    'body' => $data['body'],
                ]);
                $template->update($data);
                session()->flash('message', $msg_update_success);
                return redirect()->route("eh.system_settings.email_template.show", $template->type);
            }
        }
    }

}
