<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;

class CheckMobileApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if(Request::header('Clixells-App')!='hr-system'){
        return response(['message' => 'Device Unauthenticated'], 401);
      }
        return $next($request);
    }
}
