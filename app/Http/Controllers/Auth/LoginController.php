<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;

class LoginController extends Controller
{
    /**
     * ภารกิจ: แสดงหน้าจอ Terminal สำหรับเข้าสู่ระบบ (The Visual Terminal)
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * ภารกิจ: ตรวจสอบสิทธิ์การเข้าถึง (The Authentication Engine)
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // 📡 ดึงนโยบายการบันทึก Log มาเตรียมไว้
        $canLog = DB::table('system_settings')->where('id', 1)->value('allow_operative_logs') ?? true;

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            // 📡 [Log: Success] บันทึกร่องรอยการสถาปนาอำนาจ (เช็คสวิตช์ก่อน)
            if ($canLog) {
                ActivityLog::create([
                    'user_id'    => Auth::id(),
                    'subject'    => 'AUTH_SUCCESS',
                    'details'    => "ระบบตอบรับ: [" . Auth::user()->name . "] เข้าประจำการในศูนย์บัญชาการ",
                    'severity'   => 'info',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }

            return redirect()->intended(route('dashboard'))
                ->with('success', 'สถาปนาการเชื่อมต่อสำเร็จ!');
        }

        // 📡 [Log: Failed] บันทึกร่องรอยการพยายามบุกรุก (เช็คสวิตช์ก่อน)
        if ($canLog) {
            ActivityLog::create([
                'user_id'    => null,
                'subject'    => 'AUTH_FAILED',
                'details'    => "คำเตือน: ความพยายามเข้าถึงล้มเหลวด้วยชื่อรหัส: " . $request->username,
                'severity'   => 'warning',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return back()->withErrors([
            'username' => 'สิทธิ์การเข้าถึงถูกปฏิเสธ: ข้อมูลระบุตัวตนไม่ถูกต้อง',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        // 📡 ตรวจสอบนโยบายการบันทึกก่อนถอนกำลัง
        $canLog = DB::table('system_settings')->where('id', 1)->value('allow_operative_logs') ?? true;

        if ($canLog && Auth::check()) {
            ActivityLog::create([
                'user_id'    => Auth::id(),
                'subject'    => 'AUTH_LOGOUT',
                'details'    => "ระบบตอบรับ: [" . Auth::user()->name . "] ถอนกำลังออกจากศูนย์บัญชาการ",
                'severity'   => 'info',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        // 🛡️ ปฏิบัติการล้าง Session และสิทธิ์การเข้าถึง
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'ถอนกำลังและปิดการเชื่อมต่อปลอดภัย');
    }
}
