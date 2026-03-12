<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        // ดึงข้อมูล Log ล่าสุดพร้อมชื่อผู้ทำ (ถ้ามี) และแบ่งหน้าละ 15 รายการ
        $logs = ActivityLog::latest()->paginate(4);

        return view('admin.activity-logs', compact('logs'));
    }

    public function purge()
    {
        // ใช้ truncate เพื่อล้างข้อมูลและ reset auto-increment หรือใช้ delete() 
        ActivityLog::truncate();

        return back()->with('success', 'DATABASE_PURGED: บันทึกกิจกรรมทั้งหมดถูกทำลายแล้ว');
    }
}
