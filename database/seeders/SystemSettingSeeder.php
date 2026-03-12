<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemSetting; // 🛡️ ตรวจสอบให้มั่นใจว่าไฟล์ Model ชื่อนี้แล้ว

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        // สร้างข้อมูลชุดแรกถ้ายังไม่มีในฐานข้อมูล
        SystemSetting::updateOrCreate(
            ['id' => 1], // ป้องกันการสร้างซ้ำถ้าเผลอรันหลายรอบ
            [
                'operation_mode'      => 'SOLO',
                'system_status'       => 'ONLINE',
                'allow_operative_logs' => true,
                'max_login_attempts'   => 5,
                'ip_whitelist_only'    => false,
                'maintenance_message'  => 'VOID_COMMANDER SYSTEM IS READY.',
            ]
        );
    }
}
