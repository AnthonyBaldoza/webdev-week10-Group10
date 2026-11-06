<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/report');
Route::get('/report', [ReportController::class, 'index'])->name('report');