<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use \App\Models\ActivityLog;
use App\Models\Operative;

class OperativeController extends Controller
{

    public function create()
    {
        $operatives = Operative::latest()->paginate(5);

        // 🚩 ส่งค่า null ไปเพื่อให้ Blade รู้ว่าตอนนี้คือโหมด "เพิ่มลูกข่ายใหม่"
        return view('admin.operatives.create', [
            'operatives' => $operatives,
            'operative'  => null
        ]);
    }

    public function store(Request $request)
    {
        // 1. ตรวจสอบความถูกต้อง (Validation)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|unique:operatives',
            'level' => 'required|integer',
            'password' => 'required|min:6',
        ]);

        // 2. บันทึกลงฐานข้อมูล (Database Insertion)
        $operative = Operative::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'level' => $validated['level'],
            'password' => bcrypt($validated['password']),
        ]);

        // 📡 3. บันทึกร่องรอยการปฏิบัติการ (Activity Logging)
        // ใช้เมธอด record ที่เราสถาปนาไว้ใน ActivityLog Model
        ActivityLog::create([
            'user_id' => Auth::id(),
            'subject'    => 'ESTABLISH_ACCESS',
            'details'    => "สถาปนาลูกข่ายใหม่: {$operative->name} (Level: {$operative->level}) เข้าสู่ระบบ",
            'severity'   => 'info',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // 🚩 ส่งการตอบกลับ (Response)
        return back()->with('success', 'DEPLOYMENT_SUCCESS: สถาปนาลูกข่าย ' . $validated['name'] . ' เข้าประจำการแล้ว!');
    }

    public function edit($id)
    {
        $operatives = Operative::latest()->get(); // ดึงรายการมาโชว์ในตารางเหมือนเดิม
        $operative = Operative::findOrFail($id); // ดึงข้อมูลตัวที่จะแก้มาใส่ฟอร์ม

        return view('admin.operatives.create', compact('operatives', 'operative'));
    }

    public function update(Request $request, $id)
    {
        $operative = Operative::findOrFail($id);

        // เก็บชื่อเดิมไว้ก่อนอัปเดตเพื่อใช้ใน Log
        $oldName = $operative->name;

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|unique:operatives,username,' . $id,
            'level'    => 'required|integer',
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name'     => $validated['name'],
            'username' => $validated['username'],
            'level'    => $validated['level'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = bcrypt($validated['password']);
        }

        $operative->update($data);

        // 📡 บันทึก Log: การปรับปรุงข้อมูล
        ActivityLog::create([
            'user_id' => Auth::id(),
            'subject'    => 'OVERRIDE_RECORD',
            'details'    => "ปรับปรุงฐานข้อมูลลูกข่าย: {$oldName} (ID: #{$id}) สู่สถานะปัจจุบัน",
            'severity'   => 'warning', // ใช้สีส้มเพื่อแจ้งเตือนว่ามีการแก้ไข
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('operatives.create')->with('success', 'OVERRIDE_SUCCESS: ข้อมูลลูกข่ายถูกปรับปรุงเรียบร้อย');
    }

    public function block($id)
    {
        $operative = Operative::findOrFail($id);

        // 🛡️ ระบบป้องกันตนเอง: ห้ามบล็อกบัญชีระดับ Level 99 (Commander)
        if ($operative->level == 99) {
            return back()->with('error', 'คำเตือน: ไม่สามารถระงับสิทธิ์บัญชีระดับ MARSHAL ได้!');
        }

        // 🔄 สลับสถานะ (Toggle) ระหว่างบล็อกกับไม่บล็อก
        $operative->is_blocked = !$operative->is_blocked;
        $operative->save();

        return back()->with('success', 'สถานะลูกข่ายรหัส #' . $operative->id . ' ถูกเปลี่ยนแปลงเรียบร้อย');
    }

    public function getJson($id)
    {
        $operative = Operative::findOrFail($id);

        // ส่งข้อมูลกลับไปให้ JavaScript ในรูปแบบ JSON
        return response()->json([
            'name'     => $operative->name,
            'username' => $operative->username,
            'level'    => $operative->level,
        ]);
    }

    public function destroy($id)
    {
        $operative = Operative::findOrFail($id);

        // 🛡️ SECURITY_CHECK: ป้องกันการลบระดับบัญชาการ
        if ($operative->level == 99) {
            // 📡 บันทึก Log: ความพยายามละเมิดความปลอดภัยระดับสูงสุด
            ActivityLog::create([
                'user_id'    => Auth::id(), // ใช้ Auth Facade เพื่อไม่ให้ขึ้นเส้นแดง
                'subject'    => 'PRIVILEGE_VIOLATION',
                'details'    => "คำเตือน: ความพยายามกวาดล้างหน่วยบัญชาการระดับ 99 (ID: #{$id}) ถูกยับยั้ง!",
                'severity'   => 'critical', // สีแดงกะพริบเพื่อแจ้งเตือนภัยคุกคาม
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return back()->with('error', 'SYSTEM_PROTECTION: ไม่สามารถกำจัดหน่วยบัญชาการระดับ 99 ได้!');
        }

        // เก็บชื่อไว้ก่อนถูกลบออกจากฐานข้อมูล
        $targetName = $operative->name;

        $operative->delete();

        // 📡 บันทึก Log: ยืนยันการกวาดล้างสำเร็จ
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'subject'    => 'TERMINATE_OPERATIVE',
            'details'    => "ภารกิจเสร็จสิ้น: กวาดล้างลูกข่าย {$targetName} (ID: #{$id}) ออกจากสารบบเรียบร้อย",
            'severity'   => 'warning', // ใช้สีส้มเพื่อให้รู้ว่ามีการลบข้อมูลสำคัญ
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('operatives.index')
            ->with('success', 'TERMINATED: ข้อมูลลูกข่ายถูกกวาดล้างออกจากสารบบแล้ว');
    }
}
