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

use App\Models\EH\Employee;
use App\Models\EH\Configurations\Bank;
use App\Http\Controllers\Controller;
use App\Models\EH\Configurations\Department;
use App\Models\System\JobOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class QueueController extends Controller{

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
        'bank'=>'required',
        'swift'=>'required',
        'code'=>'required',
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
        $queues = JobOrder::all();
        return view("eh.system_settings.queue.index",compact('queues'));

    }

    /**
     * Show the selected entry record by key-in the primary ID
     *
     * @param int $id
     *
     * @return RedirectResponse
     * @return View
     */
    public function show($uuid){
        $this->mode['isModeShow']=true;

        $q = JobOrder::findOrFail($uuid);
        return view("eh.system_settings.queue.detail",compact('q'))->with('mode',$this->mode);

    }
}
