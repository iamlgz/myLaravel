<?php

namespace App\Http\Middleware;

use Closure;

class PowerMiddleware
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
        if(!session('admin_user')){
            return response()->view('remind.remind',['msg'=>'请登录','url'=>'login']);
        }
        return $next($request);
    }
}
