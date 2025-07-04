<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'ログインが必要です。');
        }
        
        return $next($request);
    }
}
