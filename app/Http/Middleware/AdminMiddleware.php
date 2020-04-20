<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Log;
use Closure;

class AdminMiddleware
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
        if(!$request->session()->has('user')){
           Log::channel('ipadmin')->alert("Unauthorized user with ip address: ".$request->ip(). " tried to access admin panel");
          //  Log::channel('ipadmin')->alert($request->ip());
            return redirect()->route("home");
        }
        $user = $request->session()->get('user');
        $username = $request->session()->get('user')->username;
        if($user->role_id !== 1) {
            Log::critical("Authorized user with username" . $username . "tried to access admin panel");
            return redirect()->route("home");
        }

        return $next($request);
    }
}
