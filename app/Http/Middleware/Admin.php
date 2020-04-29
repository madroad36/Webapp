<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
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
        if(Auth::user() == ''){
            return redirect('admin/login')->with('error','You have not admin access')->with('success','Please Login');

        }
        else{
            if(empty(Auth::user()->admin)){
                return redirect('admin/login')->with('error','You have not admin access');
            }
            if(Auth::user()->admin->name == "admin" || Auth::user()->admin->name == "receptionist"){
                return $next($request);
            }
            return redirect()->back()->with('error','You have not admin access');
        }

    }
}
