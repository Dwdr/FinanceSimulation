<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserPermission{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
//        $route_reject="mm.dashboard.index";
//        $msg_auth_reject="You are not authorized for the module";
//
//        if (!auth()->user()->can($auth)) {
//            //authorization reject
//            //show warning
//            session()->flash('alert-warning', $this->msg_auth_reject);
//            //redirect to reject page
//            return redirect()->route($route_reject);
//        }else{
//            return $next($request);
//        }
        return $next($request);
    }
}
