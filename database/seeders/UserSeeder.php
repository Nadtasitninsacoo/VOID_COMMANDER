<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operative; // ตรวจสอบชื่อ Model ของท่าน
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Strategic Data Injection
     */
    public function run(): void
    {
        // 🛡️ 1. สถาปนาบัญชี "ท่านจอมพล" (Super Admin)
        Operative::updateOrCreate(
            ['username' => 'commander_01'], // ตรวจสอบจาก ID เดิมของท่าน
            [
                'name'     => 'Keng Nadtasit (MARSHAL)',
                'level'    => 99,
                'role'     => 'admin',
                'password' => Hash::make('12345678'), // รหัสผ่านเข้ารหัสปลอดภัย
            ]
        );

        // 👨‍💻 2. สร้างลูกข่ายตัวอย่าง (Sample Operative)
        Operative::updateOrCreate(
            ['username' => 'operative_01'],
            [
                'name'     => 'Standard Operative A',
                'level'    => 1,
                'role'     => 'operative',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
