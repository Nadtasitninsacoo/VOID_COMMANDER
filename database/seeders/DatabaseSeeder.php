<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * ยุทธการฉีดข้อมูลหลักของระบบ
     */
    public function run(): void
    {
        // 🛡️ เรียกใช้ UserSeeder ที่เราสร้างไว้เพื่อสถาปนา "ท่านจอมพล"
        $this->call([
            UserSeeder::class,
            SystemSettingSeeder::class,
        ]);

        // ส่วนของ Test User เดิม ท่านจะเก็บไว้หรือคอมเมนต์ออกก็ได้ครับ
        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */
    }
}
