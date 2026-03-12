<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 🛰️ ภารกิจ: สถาปนาตารางตั้งค่าระบบ
     */
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('operation_mode')->default('SOLO'); // SOLO หรือ TEAM
            $table->string('system_status')->default('ONLINE'); // สถานะศูนย์บัญชาการ
            $table->boolean('allow_operative_logs')->default(true);

            // 🛡️ ระบบป้องกันการบุกรุกเบื้องต้น
            $table->integer('max_login_attempts')->default(5);
            $table->boolean('ip_whitelist_only')->default(false); // จำกัดเฉพาะ IP ที่อนุญาตหรือไม่

            $table->text('maintenance_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * 🛡️ ภารกิจ: ล้างทำลายตารางเมื่อถอนกำลัง (Rollback)
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
