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
            
            // Logika: Jika user mencoba mengakses URL yang berhubungan dengan admin
            // (misalnya: dashboardadmin, atau halaman lain yang diawali dashboardadmin)
            if ($request->is('dashboardadmin*')) {
                return route('loginadmin'); // Arahkan ke /panel
            }
            
            // Default: Jika bukan admin, arahkan ke login karyawan biasa
            return route('login'); // Arahkan ke /
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
