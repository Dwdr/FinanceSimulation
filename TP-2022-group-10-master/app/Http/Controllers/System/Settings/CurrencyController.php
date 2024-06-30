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

namespace App\Http\Controllers\System\Settings;

use App\Http\Controllers\Controller;
use App\Models\System\Settings\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrencyController extends Controller
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
    $currency = Currency::all();
    return view('system.settings.currency.index', compact('currency'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $this->mode['isModeCreate']=true;
    return view('system.settings.currency.detail')->with('mode',$this->mode);
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
      'currency'=>'required|string|max:70',
    ]);


    $c = Currency::create([
      'organization_id'=> Auth::user()->profile->organization_id,
      'currency'=> $request->currency,
      'status'=> $request->status == 'on',
    ]);

    session()->flash('alert-success', "Currency created.");
    return redirect()->route('system.settings.currency.show',$c->id);
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
    $c = Currency::find($id);
    return view('system.settings.currency.detail',compact('c'))->with('mode',$this->mode);
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
    $c = Currency::find($id);
    return view('system.settings.currency.detail',compact('c'))->with('mode',$this->mode);
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
      'currency'=>'required|string|max:70',
    ]);
    $c = Currency::find($id);
    $c->currency = $request->currency;
    $c->status = $request->status == 'on';
    $c->save();

    session()->flash('alert-success', "Currency updated.");
    return redirect()->route('system.settings.currency.show',$c->id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $c = Currency::find($id);
    $c->delete();
    session()->flash('alert-success', "Currency deleted.");
    return redirect()->route('system.settings.currency.index');
  }

}
