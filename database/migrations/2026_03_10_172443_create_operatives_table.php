<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operatives', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // นามเรียกขานลูกข่าย
            $table->string('username')->unique(); // ID สำหรับเข้าใช้งาน
            $table->integer('level')->default(1); // ระดับการเข้าถึง (1, 2, 3)
            $table->string('password');          // รหัสผ่านเข้ารหัส
            $table->string('role')->default('operative'); // บทบาท (operative, admin)
            $table->boolean('is_blocked')->default(false);
            $table->timestamps();                // บันทึกเวลาที่ถูกสถาปนา
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operatives');
    }
};
