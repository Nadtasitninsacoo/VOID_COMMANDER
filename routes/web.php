<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OperativeController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\SystemConfigurationController;
use App\Http\Controllers\VulnerabilityController;
use App\Http\Controllers\KillChainController;
use App\Http\Controllers\IntelligenceController;

// --- [ เขตควบคุมสูงสุด: ต้องผ่านการสถาปนาตัวตนเท่านั้น ] ---
Route::middleware(['auth'])->group(function () {

    // 🚩 ทุกคน (รวมลูกข่าย) เข้าถึงได้
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 🛡️ [ Shared Sector ] - ลูกข่ายดู Log ได้ (แต่อาจจะฟิลเตอร์ให้เห็นเฉพาะของตัวเองใน Controller)
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('logs.index');
    Route::delete('/admin/activity-logs/purge', [ActivityLogController::class, 'purge'])->name('logs.purge');

    // ⚔️ [ Sector: 99_MARSHAL_ONLY ] - สิทธิ์ขาดเฉพาะท่านจอมพล
    Route::middleware(['marshal'])->group(function () {
        // การจัดการลูกข่าย (Full Access)
        Route::get('/operatives', [OperativeController::class, 'index'])->name('operatives.index');
        Route::get('/operatives/create', [OperativeController::class, 'create'])->name('operatives.create');
        Route::post('/operatives', [OperativeController::class, 'store'])->name('operatives.store');

        // ส่วนควบคุมสถานะและการแก้ไข (Critical Actions)
        Route::patch('/admin/operatives/{id}/block', [OperativeController::class, 'block'])->name('operatives.block');
        Route::get('/admin/operatives/{id}/json', [OperativeController::class, 'getJson'])->name('operatives.json');
        Route::put('/admin/operatives/{id}', [OperativeController::class, 'update'])->name('operatives.update');
        Route::delete('/admin/operatives/{id}', [OperativeController::class, 'destroy'])->name('operatives.destroy');

        Route::get('/admin/configuration', [SystemConfigurationController::class, 'index'])->name('admin.config');
        Route::post('/admin/configuration/update', [SystemConfigurationController::class, 'update'])->name('admin.config.update');
        Route::patch('/admin/configuration/clear-broadcast', [SystemConfigurationController::class, 'clearBroadcast'])->name('admin.config.clear-broadcast');

        Route::get('/admin/kill-chain', [KillChainController::class, 'index'])->name('admin.kill_chain');
        Route::post('/admin/kill-chain/execute', [KillChainController::class, 'executeStrike'])->name('admin.kill_chain.execute');
        Route::post('/execute-strike', [KillChainController::class, 'executeStrike'])->name('execute-strike');
        Route::post('/admin/execute-strike', [KillChainController::class, 'executeStrike'])->name('admin.execute-strike');
    });

    Route::get('/admin/vulnerability-scan', [VulnerabilityController::class, 'index'])->name('admin.vulnerability_scan');
    Route::post('/admin/vulnerability-scan', [VulnerabilityController::class, 'store'])->name('vulnerability.store');

    Route::get('/admin/intelligence', [IntelligenceController::class, 'index'])->name('admin.intelligence');
    Route::delete('/admin/intelligence/{id}', [IntelligenceController::class, 'destroy'])->name('admin.intelligence.destroy');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// --- [ เขตสาธารณะ ] ---
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});
