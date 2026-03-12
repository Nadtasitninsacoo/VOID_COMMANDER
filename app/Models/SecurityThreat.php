<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityThreat extends Model
{
    // กำหนดชื่อตารางให้ตรงกับ Migration
    protected $table = 'security_threats';

    protected $fillable = [
        'category_id',    // 1-10 ตามรหัสลับของท่านจอมพล
        'source_ip',
        'attack_pattern',
        'status',
    ];

    // แปลงข้อมูล JSON (เช่น พฤติกรรม DoS/SQLi) ให้เป็น Array อัตโนมัติ
    protected $casts = [
        'attack_pattern' => 'array',
    ];
}
