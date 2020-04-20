<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Log;
use Closure;

class CheckAuth
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
      //  return $next($request);
        if(!$request->session()->has('user')){
            Log::alert("Unauthorized user with ip address: ".$request->ip(). "tried to access page where user must be authorized");
           // Log::channel('ip')->alert($request->ip());
            return redirect()->route('home');
        }

        return $next($request);
    }
}
