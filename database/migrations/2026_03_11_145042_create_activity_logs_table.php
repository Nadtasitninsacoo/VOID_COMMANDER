<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // 👤 ผู้กระทำการ (เชื่อมกับตาราง users)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('operatives') // <--- ระบุชื่อตารางเป้าหมายที่นี่!
                ->onDelete('set null');

            // 📝 รายละเอียดเหตุการณ์
            $table->string('subject');          // หัวข้อ เช่น 'OPERATIVE_CREATED', 'SYSTEM_LOGIN'
            $table->text('details')->nullable(); // รายละเอียดเชิงลึก เช่น 'Created operative ID: 09'

            // 🚦 ระดับความรุนแรง (ใช้เก็บ: info, warning, critical)
            $table->string('severity')->default('info');

            // 🌐 ร่องรอยทางดิจิทัล
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();     // ข้อมูล Browser/อุปกรณ์

            $table->timestamps();

            // Index เพื่อการค้นหาที่รวดเร็วระดับจอมพล
            $table->index('severity');
            $table->index('subject');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
