<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL; // <--- เพิ่มการใช้ URL

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. บังคับใช้ HTTPS เมื่ออยู่บน Production (แก้ปัญหา Tailwind/CSS ไม่ทำงาน)
        if (config('app.env') === 'production' || $this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // 2. ป้องกัน Error ตอน Migrate หรือตอนฐานข้อมูลยังว่างเปล่า
        try {
            if (Schema::hasTable('system_settings')) {
                // ใช้การดึงข้อมูลแบบปลอดภัย
                $settings = SystemSetting::first();
                view()->share('globalSettings', $settings);
            }
        } catch (\Exception $e) {
            // ถ้าเกิด Error เรื่อง DB ให้ข้ามไปก่อน ไม่ให้หน้าเว็บล่ม (500)
            view()->share('globalSettings', null);
        }
    }
}
