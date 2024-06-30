<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRoleIsUser{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if (Auth::user()->hasRole(config('constants.ROLE.USER'))) {
            return $next($request);
        }else{
            $msg_auth_reject="You are not authorized for the module";
            session()->flash('alert-warning', $msg_auth_reject);
            return redirect('entry-selector');
        }
    }
}
