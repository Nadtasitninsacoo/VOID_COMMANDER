<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBlocked
{
    public function handle(Request $request, Closure $next)
    {
        // 🛡️ PROTOCOL: ACCESS_TERMINATED
        if (Auth::check() && Auth::user()->is_blocked) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // ส่งกลับหน้า Login พร้อมข้อความระบบที่ดูเป็นความลับ (System Error)
            return redirect()->route('login')->with('error', 'ACCESS_DENIED: UNAUTHORIZED_CONNECTION_DETECTED');
        }

        return $next($request);
    }
}
