<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntelligenceReport extends Model
{
    use HasFactory;

    /**
     * ชื่อตารางที่โมเดลนี้ควบคุม
     */
    protected $table = 'intelligence_reports';

    /**
     * รายการคอลัมน์ที่อนุญาตให้บันทึกข้อมูลแบบ Mass Assignment
     */
    protected $fillable = [
        'source_ip',
        'leaked_data',
        'captured_at',
        'file_path',
        'file_type',
        'file_size',
    ];

    /**
     * การแปลงประเภทข้อมูลอัตโนมัติ (Data Casting)
     */
    protected $casts = [
        'captured_at' => 'datetime',
        'file_size'   => 'integer',
        // หาก leaked_data ถูกบันทึกเป็น JSON จาก Controller 
        // ให้ปลดคอมเมนต์บรรทัดล่างเพื่อให้ใช้งานแบบ Array ได้ทันที
        // 'leaked_data' => 'array', 
    ];

    /**
     * Helper Method: ตรวจสอบว่ารายงานนี้มีไฟล์แนบมาด้วยหรือไม่
     */
    public function hasFile()
    {
        return !empty($this->file_path);
    }

    /**
     * Helper Method: แปลงขนาดไฟล์จาก Byte เป็นหน่วยที่อ่านง่าย (KB, MB)
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        for ($i = 0; $bytes > 1024; $i++) $bytes /= 1024;
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
