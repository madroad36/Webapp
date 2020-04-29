<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UrlMiddleware
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

        if(Auth::check()){

            return $next($request);
        }
        else{
            if($request->ajax()){
                return response()->json(['errors'=>'login'],422);
            }
            $url = $request->path();
            return redirect('/login')->with('url',$url);
        }
    }
}
