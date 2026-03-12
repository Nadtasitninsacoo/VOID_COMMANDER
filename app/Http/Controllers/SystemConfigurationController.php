<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SystemConfigurationController extends Controller
{
    public function index()
    {
        // 🛰️ พยายามดึงข้อมูลนโยบายชุดแรก
        $settings = DB::table('system_settings')->first();

        // 🛡️ [Protocol: Self-Healing] หากยังไม่มีข้อมูลในคลัง ให้สร้างค่าเริ่มต้นทันที
        if (!$settings) {
            DB::table('system_settings')->insert([
                'id' => 1,
                'operation_mode' => 'SOLO',
                'system_status' => 'ONLINE',
                'allow_operative_logs' => true,
                'max_login_attempts' => 5, // ตามโครงสร้างที่เราเพิ่มไปก่อนหน้า
                'ip_whitelist_only' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ดึงข้อมูลใหม่อีกครั้งหลังจากสถาปนาเสร็จ
            $settings = DB::table('system_settings')->first();
        }

        return view('admin.configuration', compact('settings'));
    }

    public function update(Request $request)
    {
        // 1. อัปเดตตารางควบคุม (Policy Store)
        DB::table('system_settings')->where('id', 1)->update([
            'operation_mode' => $request->operation_mode,
            'system_status' => $request->system_status,
            'allow_operative_logs' => $request->has('allow_operative_logs'),
            'maintenance_message' => $request->maintenance_message,
            'updated_at' => now(),
        ]);

        // 2. บันทึกหลักฐานลงในตาราง Log (Activity Tracking) 
        // เพื่อให้ข้อมูลไปปรากฏในหน้า Audit Trail ที่ท่านมีอยู่แล้ว
        DB::table('activity_logs')->insert([
            'user_id' => Auth::id(),
            'subject'    => 'SYSTEM_CONFIG_UPDATED',
            'details'    => "ท่านจอมพลปรับปรุงนโยบาย: Mode=" . $request->operation_mode . " | Status=" . $request->system_status,
            'severity'   => 'warning', // ใช้สีส้มเพื่อบอกว่าเป็นระดับการตั้งค่าสำคัญ
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'สถาปนานโยบายใหม่และบันทึกร่องรอยลงใน Log สำเร็จ');
    }

    public function clearBroadcast()
    {
        // ค้นหาข้อมูลแถวแรกและล้างข้อความ
        $setting = \App\Models\SystemSetting::first();

        if ($setting) {
            $setting->update([
                'maintenance_message' => null
            ]);
        }

        return back()->with('success', 'BROADCAST_SIGNAL_TERMINATED: สัญญาณถูกระงับแล้ว');
    }
}
