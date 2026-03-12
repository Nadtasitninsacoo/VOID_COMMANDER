<?php

namespace App\Models;

// 🛡️ ใช้ Authenticatable แทน Model ปกติ
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Operative extends Authenticatable
{
    use Notifiable;

    protected $table = 'operatives'; // ระบุชื่อตารางให้ชัดเจน

    protected $fillable = [
        'name',
        'username',
        'password',
        'level',
        'role',
        'is_blocked',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
