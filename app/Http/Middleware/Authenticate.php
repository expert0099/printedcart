<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;use Session;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->guest()){
            if($request->ajax() || $request->wantsJson()){
                return response('Unauthorized.', 401);
            } else {
				$url_segment = \Request::segment(1);
				if($url_segment == 'admin'){
					return redirect()->guest('admin/login');
				}else{					
					if(null!==Session::get('logout') && Session::get('logout') == 'yes'){						
						Session::forget('logout');						
						return redirect()->guest('user/logout_verify');											
					}else{						
						return redirect()->guest('user/login');					
					}					
				}
            }
        }
        return $next($request);
    }
}
