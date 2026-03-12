<?php

use App\Http\Controllers\CallbackController;
use Illuminate\Support\Facades\Route;

// 🚩 ท่าเรือรับข้อมูลข่าวกรอง (Intelligence Port)
// พิกัดคือ: http://your-domain.com/api/v1/collect
Route::any('/v1/collect', [CallbackController::class, 'handleCallback'])->name('api.collect');
