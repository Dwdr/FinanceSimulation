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

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Ramsey\Uuid\Type\Integer;

class FileController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
    }

    public function grab_file(Request $request) {
        if (!isset($request->p)) {
            abort(404);
        }
        $s = $request->s; // school slug
        $p = $request->p; // file path (app/files)
        $fn = $request->fn; // file name
        $dl = $request->dl; // download?

        if (!Storage::disk('private')->exists($p)) {
            abort(404);
        } else if (!Str::contains($p, $s)) {
            abort(404);
        } else if (!Auth::user()->profile->organization->name_slug == $s) {
            abort(404);
        }

//    if($t == config('constants.FILE_TYPE.CONTENT')){
        $header = [
            'Content-Type' => Storage::disk('private')->mimeType($p),
            'Cache-Control' => 'max-age=1800',
        ];
//    }else{
//      $header = [
//        'Cache-Control' => 'no-cache, no-store, must-revalidate',
//        'Pragma' => 'no-cache',
//        'Expires' => '0',
//      ];
//    }


        if ($dl) {
            return Response::download(Storage::disk('private')->path($p), $fn, $header);
        } else {
            return Response::file(Storage::disk('private')->path($p), $header);
        }
    }

}
