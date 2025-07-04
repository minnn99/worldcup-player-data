<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'ログインが必要です。');
        }
        
        if (session('user_role') !== 0) {
            return redirect()->route('players.index')->with('error', '管理者権限が必要です。');
        }
        
        return $next($request);
    }
}
