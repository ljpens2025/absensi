<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:karyawan')->group(function (){
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin'])->name('proseslogin');
});

Route::middleware('guest:user')->group(function (){
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');
    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin'])->name('prosesloginadmin');
});


Route::middleware('auth:karyawan')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/proseslogout', [AuthController::class, 'logout'])->name('logout');
    //presensi
    Route::get('/presensi/create', [PresensiController::class, 'create'])->name('createPresensi');
    Route::post('/presensi/store', [PresensiController::class, 'store'])->name('storePresensi');
    //edit profile
    Route::get('/editprofile', [PresensiController::class, 'editprofile'])->name('editProfilePresensi');
    Route::post('/presensi/{nik}/updateprofile', [PresensiController::class, 'updateprofile'])->name('updateProfilePresensi');
    //histori presensi
    Route::get('/histori', [PresensiController::class, 'histori'])->name('historiPresensi');
    Route::post('/gethistori', [PresensiController::class, 'gethistori'])->name('getHistoriPresensi');
    //izin
    Route::get('/izin', [PresensiController::class, 'izin'])->name('izinPresensi');
    Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin'])->name('buatizinPresensi');
    Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin'])->name('storeizinPresensi');
});
Route::middleware('auth:user')->group(function () {
    Route::get('/dashboardadmin', [DashboardController::class, 'dashboardadmin'])->name('dashboardadmin');
    Route::get('/proseslogoutadmin', [AuthController::class, 'logoutadmin'])->name('logoutadmin');
});
