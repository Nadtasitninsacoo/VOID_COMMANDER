<?php

namespace App\Http\Controllers;

use App\Models\IntelligenceReport;
use Illuminate\Http\Request;

class IntelligenceController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลล่าสุดขึ้นมาแสดงก่อน
        $reports = IntelligenceReport::orderBy('captured_at', 'desc')->paginate(15);

        return view('admin.intelligence', compact('reports'));
    }

    public function destroy($id)
    {
        // ทำลายหลักฐานเมื่อไม่ต้องการแล้ว
        $report = IntelligenceReport::findOrFail($id);
        $report->delete();

        return back()->with('success', 'Intelligence report purged.');
    }
}
