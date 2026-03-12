<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $table = 'system_settings';

    protected $fillable = [
        'operation_mode',
        'system_status',
        'allow_operative_logs',
        'max_login_attempts',
        'ip_whitelist_only',
        'maintenance_message'
    ];
}
