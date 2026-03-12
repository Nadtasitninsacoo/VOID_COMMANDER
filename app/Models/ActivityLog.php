<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request; // เรียกมาแล้ว
use Illuminate\Support\Facades\Auth;    // เรียกมาแล้ว

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'subject', 'details', 'severity', 'ip_address', 'user_agent'];

    public static function record($subject, $details = null, $severity = 'info')
    {
        // ✅ เปลี่ยนจาก auth()->check() เป็น Auth::check()
        $userId = Auth::check() ? Auth::id() : null;

        return self::create([
            'user_id'    => $userId,
            'subject'    => $subject,
            'details'    => $details,
            'severity'   => $severity,
            // ✅ เปลี่ยนจาก request()->ip() เป็น Request::ip()
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
