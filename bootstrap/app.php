<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// 🛰️ นำเข้าด่านตรวจ (Middleware) แยกไว้ด้านบนเพื่อความเป็นระเบียบ
use App\Http\Middleware\CheckBlocked;
use App\Http\Middleware\CheckMarshal;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // 1. 🛡️ Global Web Check: บังคับใช้ CheckBlocked ในทุกหน้าของเว็บไซต์
        $middleware->web(append: [
            CheckBlocked::class,
        ]);

        // 2. 🔑 Alias Registration: ลงทะเบียนชื่อย่อสำหรับเรียกใช้ใน Routes
        $middleware->alias([
            'marshal'       => CheckMarshal::class,
            'check.blocked' => CheckBlocked::class, // เผื่อเรียกใช้แยกจุด
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
