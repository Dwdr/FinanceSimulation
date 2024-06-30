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
use App\Models\Auth\Organization;
use App\Models\Auth\User;
use App\Models\Auth\UserOAuth;
use App\Models\Auth\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OrganizationController extends Controller
{

  private $mode=[
    'isModeShow'=>false,
    'isModeCreate'=>false,
    'isModeEdit'=>false,
  ];

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    $organizations = Organization::all();
    return view('system.organization.index', compact('organizations'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    // todo Role select

    $this->mode['isModeCreate']=true;
    return view('system.organization.detail')->with('mode',$this->mode);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request,[
      'name'=>'required|string|max:255',
    ]);
    $o = Organization::create([
      'name' => $request->name,
    ]);

    session()->flash('alert-success', "Organization created.");
    return redirect()->route('system.organization.show',$o->id);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $this->mode['isModeShow']=true;
    $o = Organization::find($id);
    return view('system.user.detail',compact('o'))->with('mode',$this->mode);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $this->mode['isModeEdit']=true;
    $o = Organization::find($id);
    $o->load('owner');
    return view('system.user.detail',compact('o'))->with('mode',$this->mode);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $this->validate($request,[
      'name'=>'required|string|max:255',
    ]);
    $o = organization::find($id);
    $o->name = $request->name;
    $o->save();

    session()->flash('alert-success', "Organization updated.");
    return redirect()->route('system.organization.show',$o->id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $o = Organization::find($id);
    $o->delete();
    session()->flash('alert-success', "Organization deleted.");
    return redirect()->route('system.organization.index');
  }

}
