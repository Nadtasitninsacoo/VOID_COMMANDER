<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// --- เชื่อมต่อคลังแสง Model ทั้งหมด ---
use App\Models\Operative;
use App\Models\ActivityLog;
use App\Models\CapturedLoot;
use App\Models\EspionageTask;
use App\Models\SecurityThreat;
use App\Models\IntelligenceReport;

class DashboardController extends Controller
{
    public function index()
    {
        // --- 1. ข้อมูลสำหรับกราฟ (Operatives) ---
        $lvlLow = Operative::where('level', '<', 5)->count();
        $lvlHigh = Operative::where('level', '>=', 5)->count();

        $statusAct = Operative::where('is_blocked', 0)->where('role', 'operative')->count();
        $statusSby = Operative::where('role', 'commander')->count(); // หรือเงื่อนไขที่ท่านใช้แบ่ง SBY
        $statusBlk = Operative::where('is_blocked', 1)->count();

        // --- 2. ข้อมูล Captured Loots ---
        $dbDumps = CapturedLoot::where('type', 'database')->count();
        $apiKeys = CapturedLoot::where('type', 'api_key')->count();

        // --- 3. ข้อมูลสำหรับการ์ดด้านล่าง (ข้อมูลจริง) ---
        $totalNodes = Operative::count();
        $activeNodes = Operative::where('is_blocked', 0)->count();
        $integrity = ($totalNodes > 0) ? ($activeNodes / $totalNodes) * 100 : 0;

        // ดึงภัยคุกคามล่าสุดมาโชว์ 4 อัน
        $threats = SecurityThreat::latest()->take(4)->get();

        // ระดับความเสี่ยง (Logic สมมติ: ถ้ามี Breach เยอะ ให้เป็น High)
        $hasBreach = SecurityThreat::where('status', 'breached')->exists();
        $threatLevel = $hasBreach ? 'HIGH' : 'LOW';

        return view('welcome', compact(
            'lvlLow',
            'lvlHigh',
            'statusAct',
            'statusSby',
            'statusBlk',
            'dbDumps',
            'apiKeys',
            'totalNodes',
            'activeNodes',
            'integrity',
            'threatLevel',
            'threats'
        ));
    }
}
