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

namespace App\Http\Controllers\EH\Configurations;

use App\Models\EH\Configurations\Site;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class SiteController extends Controller{

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
        'site'=>'required',
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

        $sites = Site::all();
        return view("eh.configurations.site.index", compact('sites'));

    }

    /**
     * Show the create page for the function.
     *
     * @return RedirectResponse
     * @return View
     */
    public function create(){
        $this->mode['isModeCreate']=true;
        return view("eh.configurations.site.detail")->with('mode',$this->mode);
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
        $msg_store_success="Site created.";

        $request->validate($this->validation_rules);
        $data = $request->all();
        $data['organization_id'] = Auth::user()->profile->organization_id;
        $data['creator_id'] = Auth::user()->id;
        $data['site'] = serialize($request->site);
        $data['gps'] = serialize($request->gps);
        $data['is_active'] = $this->checkbox2boolean($data, 'is_active');
        $site = Site::create($data);
        session()->flash('message', $msg_store_success);
        return redirect()->route("eh.configurations.site.show", $site->id);

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
        $s = Site::findOrFail($id);
        return view("eh.configurations.site.detail", compact('s'))->with('mode',$this->mode);
    }

    /**
     * Show the clone page for the selected record.
     *
     * @param int $id
     *
     * @return RedirectResponse
     * @return View
     */
    public function clone($id){
        $this->mode['isModeClone']=true;

        $s = Site::findOrFail($id);
        return view("eh.configurations.site.detail",compact('s'))->with('mode',$this->mode);
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
        $s = Site::findOrFail($id);
        return view("eh.configurations.site.detail",compact('s'))->with('mode',$this->mode);
    }

    /**
     * Update the input value inputted from create page
     *
     * @param  Request   $request
     * @param  Site   $site
     *
     * @return RedirectResponse
     * @return RedirectResponse
     */
    public function update(Request $request, Site $site){
        $msg_update_success="Site updated.";

        $request->validate($this->validation_rules);
        $data = $request->all();
        $data['site'] = serialize($request->site);
        $data['gps'] = serialize($request->gps);
        $data['is_active'] = $this->checkbox2boolean($data, 'is_active');
        $site->update($data);
        session()->flash('message', $msg_update_success);
        return redirect()->route("eh.configurations.site.show", $site->id);
    }

    /**
     * Delete the input value inputted from create page
     *
     * @param  Site   $site
     * @return RedirectResponse
     */
    public function destroy(Site $site){
        $msg_destroy_success="Site deleted.";
        $site->delete();
        session()->flash('message', $msg_destroy_success);
        return redirect()->route("eh.configurations.site.index");
    }

}
