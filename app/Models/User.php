<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * 🛰️ ระบุชื่อตารางที่เป็นศูนย์เก็บข้อมูลกำลังพล
     */
    protected $table = 'operatives'; // <--- เพิ่มบรรทัดนี้ครับท่านจอมพล

    /**
     * รายการฟิลด์ที่อนุญาตให้บันทึก (เพิ่ม username เข้าไปแล้ว)
     */
    protected $fillable = [
        'username',
        'name',
        'level',      // เพิ่มเพื่อให้บันทึกระดับอำนาจได้
        'role',       // เพิ่มตามโครงสร้างตาราง operatives ของท่าน
        'is_blocked', // เพิ่มเพื่อรองรับระบบความปลอดภัย
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
