<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Pemohon\PengajuanController;
use App\Http\Controllers\Keuangan\DashboardController as KeuanganDashboard;


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/register', [AuthController::class, 'register']);

Route::post('/register', [AuthController::class, 'store']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| PEMOHON
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pemohon'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/pengajuan/create', [PengajuanController::class, 'create']);

    Route::post('/pengajuan/store', [PengajuanController::class, 'store']);

    Route::get('/pengajuan/edit/{id}', [PengajuanController::class, 'edit']);

    Route::post('/pengajuan/update/{id}', [PengajuanController::class, 'update']);

});

/*
|--------------------------------------------------------------------------
| KEUANGAN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:keuangan'])->group(function () {

    Route::get('/keuangan/dashboard', [KeuanganDashboard::class, 'index']);

    Route::post('/keuangan/approve/{id}', [KeuanganDashboard::class, 'approve']);

    Route::post('/keuangan/reject/{id}', [KeuanganDashboard::class, 'reject']);

    Route::get('/keuangan/pembukuan', [KeuanganDashboard::class, 'pembukuan']);

    Route::get('/keuangan/pembukuan/edit/{id}', [KeuanganDashboard::class, 'editPembukuan']);

    Route::get('/keuangan/permohonan', [KeuanganDashboard::class, 'permohonan']);

    Route::post('/keuangan/update-status/{id}', [KeuanganDashboard::class, 'updateStatus']);

    Route::post('/keuangan/update-jurnal/{id}', [KeuanganDashboard::class, 'updateJurnal']);

    Route::get('/keuangan/user', [KeuanganDashboard::class, 'user']);

    Route::post('/keuangan/user/store', [KeuanganDashboard::class, 'storeUser']);

    Route::post('/keuangan/user/update/{id}', [KeuanganDashboard::class, 'updateUser']);

    Route::post('/keuangan/user/delete/{id}', [KeuanganDashboard::class, 'deleteUser']);

    Route::post('/notifications/read-all',[KeuanganDashboard::class, 'readNotifications']);

    Route::post('/keuangan/upload-jurnal/{id}', [KeuanganDashboard::class, 'uploadJurnal']);

    Route::get('/keuangan/profile', [KeuanganDashboard::class, 'profile']);

    Route::get('/keuangan/update-password', [KeuanganDashboard::class, 'updatePassword']);

    Route::post('/keuangan/update-password', [KeuanganDashboard::class, 'updatePassword']);

    Route::get('/keuangan/profile', [KeuanganDashboard::class, 'profile']);
    Route::post('/keuangan/profile/update', [KeuanganDashboard::class, 'updateProfile']);

    Route::get('/keuangan/password', [KeuanganDashboard::class, 'password']);
    Route::post('/keuangan/password/update', [KeuanganDashboard::class, 'updatePassword']);

    Route::delete('/notification/{id}', [KeuanganDashboard::class, 'deleteNotification']);
    Route::delete('/notifications/delete-all', [KeuanganDashboard::class, 'deleteAllNotifications']);

    Route::delete('/pemohon/notification/{id}', [DashboardController::class, 'deleteNotification']);
    Route::delete('/pemohon/notifications/delete-all', [DashboardController::class, 'deleteAllNotifications']);

    Route::get('/profile', [DashboardController::class, 'profile']);
    Route::post('/profile/update', [DashboardController::class, 'updateProfile']);

    Route::get('/password', [DashboardController::class, 'password']);
    Route::post('/password/update', [DashboardController::class, 'updatePassword']);

    Route::get('/keuangan/rejected', [KeuanganDashboard::class, 'rejected']);
    Route::post('/keuangan/rejected/restore/{id}', [KeuanganDashboard::class, 'restore']);
    Route::delete('/keuangan/rejected/delete/{id}', [KeuanganDashboard::class, 'destroyRejected']);

    Route::post('/keuangan/rejected/bulk-restore', [KeuanganDashboard::class, 'bulkRestore']);
    Route::delete('/keuangan/rejected/bulk-delete', [KeuanganDashboard::class, 'bulkDelete']);

    Route::delete('/keuangan/pembukuan/bulk-delete', [KeuanganDashboard::class, 'bulkDeletePembukuan'])->name('pembukuan.bulk.delete');

});

