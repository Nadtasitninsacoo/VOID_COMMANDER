<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EspionageTask extends Model
{
    protected $table = 'espionage_tasks';

    protected $fillable = [
        'task_name',
        'target_url',
        'status',
        'last_run_at',
    ];

    // กำหนดรูปแบบเวลาให้จัดการง่าย
    protected $casts = [
        'last_run_at' => 'datetime',
    ];
}
