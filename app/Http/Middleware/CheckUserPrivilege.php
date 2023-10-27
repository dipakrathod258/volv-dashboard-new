<?php

namespace App\Http\Middleware;
use App\User;
use Closure;

class CheckUserPrivilege
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
        $data = User::where("email", $request->email);       
        return $next($request);
    }
}
