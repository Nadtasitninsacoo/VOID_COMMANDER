<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Schema;

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
        if (Schema::hasTable('system_settings')) {
            // ตอนนี้รันผ่านแน่นอน เพราะมีทั้ง Table, มีทั้ง Class และมีข้อมูลแถวแรกแล้ว!
            view()->share('globalSettings', \App\Models\SystemSetting::first());
        }
    }
}
