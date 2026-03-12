<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. ตารางเก็บข้อมูลที่จารกรรมมาได้ (Loot Storage)
        Schema::create('captured_loots', function (Blueprint $table) {
            $table->id();
            $table->string('target_domain')->index();
            $table->string('entry_point'); // เช่น API Path หรือ Vulnerable URL
            $table->enum('data_type', ['database_dump', 'session_cookie', 'config_file', 'api_key']);
            $table->longText('payload');   // ข้อมูลดิบที่ดูดมาได้
            $table->string('type')->nullable();
            $table->integer('risk_level')->default(1); // 1-5
            $table->timestamps();
        });

        // 2. ตารางวิเคราะห์ภัยคุกคาม 10 หมวดหมู่ (Anomaly Engine)
        Schema::create('security_threats', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('category_id'); // 1-10 ตามที่ท่านจอมพลกำหนด
            $table->string('source_ip', 45)->index();
            $table->json('attack_pattern'); // เก็บพฤติกรรมการแฮ็ก เช่น DoS, SQLi
            $table->enum('status', ['detected', 'intercepted', 'neutralized']);
            $table->timestamps();
        });

        // 3. ตารางบันทึกการทำงานของสายลับ AI (Bot Operations)
        Schema::create('espionage_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_name');
            $table->string('target_url');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'failed']);
            $table->timestamp('last_run_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('captured_loots');
        Schema::dropIfExists('security_threats');
        Schema::dropIfExists('espionage_tasks');
    }
};
