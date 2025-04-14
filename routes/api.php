<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TinController;
use App\Http\Controllers\LoaiTinController;
use App\Http\Controllers\NhomTinController;
use App\Http\Controllers\BinhLuanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\BinhLuanControllerAdmin;
use App\Http\Controllers\Admin\LoaiTinControllerAdmin;
use App\Http\Controllers\Admin\NhomTinControllerAdmin;
use App\Http\Controllers\Admin\TinControllerAdmin;

// Public routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Dashboard
    Route::get('/dashboard/statistics', [DashboardController::class, 'statistics']);
    
    // Tin
    Route::apiResource('tins', TinController::class);
    
    // Loai Tin
    Route::apiResource('loai-tins', LoaiTinController::class);
    
    // Nhom Tin
    Route::apiResource('nhom-tins', NhomTinController::class);
    
    // Binh Luan
    Route::get('binh-luans', [BinhLuanController::class, 'index']);
    Route::patch('binh-luans/{binhLuan}/status', [BinhLuanController::class, 'updateStatus']);
    Route::delete('binh-luans/{binhLuan}', [BinhLuanController::class, 'destroy']);
});

// Routes for LoaiTin
Route::get('loai-tin/{loaiTin}/tin', [LoaiTinController::class, 'getTinByLoaiTin']);

// Routes for Tin
Route::get('tin/search', [TinController::class, 'search']);
Route::get('tin-hot', [TinController::class, 'getTinHot']);

// Routes for BinhLuan
Route::get('tin/{tin}/binh-luan', [BinhLuanController::class, 'getBinhLuanByTin']); 


// Admin routes
Route::prefix('admin')->group(function () {


    //BinhLuan
    Route::get('binh-luan', [BinhLuanControllerAdmin::class, 'index']);
    Route::put('binh-luan/{id}', [BinhLuanControllerAdmin::class, 'update']);
    Route::delete('binh-luan/{id}', [BinhLuanControllerAdmin::class, 'destroy']);
    Route::post('binh-luan', [BinhLuanControllerAdmin::class, 'store']);

    //Tin
    Route::get('tin', [TinControllerAdmin::class, 'index']);
    Route::get('tin/{id}', [TinControllerAdmin::class, 'show']);
    Route::post('tin',[TinControllerAdmin::class,'store']);
    Route::put('tin/{id}', [TinControllerAdmin::class, 'update']);
    Route::delete('tin/{id}', [TinControllerAdmin::class, 'destroy']);

    //LoaiTin
    Route::get('loai-tin', [LoaiTinControllerAdmin::class, 'index']);
    Route::get('loai-tin/{id}', [LoaiTinControllerAdmin::class, 'show']);
    Route::put('loai-tin/{id}', [LoaiTinControllerAdmin::class, 'update']);
    Route::post('loai-tin',[LoaiTinControllerAdmin::class,'store']);
    Route::delete('loai-tin/{id}', [LoaiTinControllerAdmin::class, 'destroy']);

    //NhomTin
    Route::get('nhomtin', [NhomTinControllerAdmin::class, 'index'])->name('admin.nhomtin.index');
    Route::post('nhomtin', [NhomTinControllerAdmin::class, 'store'])->name('admin.nhomtin.store');
    Route::get('nhomtin/{nhomTin}', [NhomTinControllerAdmin::class, 'show'])->name('admin.nhomtin.show');
    Route::put('nhomtin/{nhomTin}', [NhomTinControllerAdmin::class, 'update'])->name('admin.nhomtin.update');
    Route::delete('nhomtin/{nhomTin}', [NhomTinControllerAdmin::class, 'destroy'])->name('admin.nhomtin.destroy');
});