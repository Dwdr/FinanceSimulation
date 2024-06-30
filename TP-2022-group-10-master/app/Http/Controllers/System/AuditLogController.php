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
use App\Models\System\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
  public function index()
  {
    if (!auth()->user()->can('system.audit_log.r')) {
      session()->flash('alert-warning', "You are not authorized for the module \"Audit Log\". ");
      return redirect()->route('dashboard.index');
    }
    $auditLogs = AuditLog::all();
    return view('system.audit-log.index', compact('auditLogs'));

  }

  public function show(AuditLog $auditLog)
  {
    return view('system.audit-log.detail', compact('auditLog'));
  }
}
