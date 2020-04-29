<?php

namespace App\Http\Middleware;

use Closure;
Use Auth;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$permission)
    {

            $user = Auth::user();
            if (!$user->can($permission)) {
                return redirect()->back()->with(['permission-errors'=>'You dont have permissions']);
            }

            return $next($request);

    }
}
