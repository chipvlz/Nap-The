<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        if (empty(\Auth::user()->is_admin)){
            return $next($request);
        } else {
            return redirect()->route('home.index')->withErrors("Bạn không có quyền truy cập");
        }
    }
}
