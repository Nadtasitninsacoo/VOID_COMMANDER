<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapturedLoot extends Model
{
    // กำหนดชื่อตารางให้ชัดเจน ป้องกันระบบเดาผิด
    protected $table = 'captured_loots';

    protected $fillable = [
        'target_domain',
        'entry_point',
        'data_type',
        'payload',
        'type',
        'risk_level',
    ];
}
