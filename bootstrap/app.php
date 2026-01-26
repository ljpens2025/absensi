<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Tambahkan logika ini:
        $middleware->redirectGuestsTo(function (Request $request) {
            // 1. Logika untuk user BELUM LOGIN (yang kita buat sebelumnya)
            if ($request->is('dashboardadmin*')) {
                return route('loginadmin');
            }
            return route('login');
        });

        // 2. Logika untuk user SUDAH LOGIN (Tambahan Baru)
        $middleware->redirectUsersTo(function (Request $request) 
        {
        
            // Cek apakah user login menggunakan guard 'user' (Administrator)
            if (auth()->guard('user')->check()) {
                return route('dashboardadmin');
            }
            // Cek apakah user login menggunakan guard 'karyawan'
            if (auth()->guard('karyawan')->check()) {
                return route('dashboard');
            }

            // Default fallback (jika ada guard lain)
            return '/';
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
