<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckMarshal
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 🛡️ ตรวจสอบลายนิ้วมือดิจิทัล (Double-Check)
        // ต้องมี Level 99 และ Role เป็น admin เท่านั้น
        if (Auth::check() && Auth::user()->level == 99 && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // 🚨 ปฏิเสธการเข้าถึงและบันทึกเหตุการณ์บุกรุก (ดีดออกไปหน้า Dashboard หรือ Login)
        return redirect()->route('login')->with('error', '🚨 CRITICAL_ACCESS_DENIED: ท่านไม่มีอำนาจสั่งการในส่วนนี้!');
    }
}
