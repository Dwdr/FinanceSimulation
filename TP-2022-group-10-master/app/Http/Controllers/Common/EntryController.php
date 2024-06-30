<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EntryController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
    }


    # set default to admin?
    public function selector(Request $request)
    {
        $request->session()->save();
        switch (Auth::user()->getRoleNames()[0]){
            case (config('constants.ROLE.ADMIN')):
                return redirect('eh/dashboard');
            case (config('constants.ROLE.USER')):
                return redirect('ssc/dashboard');
            case (config('constants.ROLE.JOBS-EMPLOYER')):
                return redirect('jobs/dashboard');
            case (config('constants.ROLE.JOBS-SEEKER')):
                return redirect('jobs/dashboard');
        }
    }
}
