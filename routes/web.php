<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Mail\TestMail;
use Illuminate\Container\Attributes\Auth;



Route::middleware('guest')->group(function () {
    Route::get('/', function () {
    /*
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
    */
    return Inertia::render('Auth/Login');
});
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/home', function () {
    return Inertia::render('Home');
})->middleware(['auth', 'verified'])->name('home');
    Route::get('/logout', function () {
    return Inertia::render('Auth/Login');
})->name('logout');
    Route::get('/report', function () {
    return Inertia::render('Report');
})->name('report');
     Route::get('/setting', function () {
    return Inertia::render('Setting');
})->name('setting');
     Route::get('/admin-user', function () {
    return Inertia::render('Administrasi/User');
})->name('admin-user');
     Route::get('/admin-customer', function () {
    return Inertia::render('Administrasi/Customer');
})->name('admin-customer');
     Route::get('/admin-material', function () {
    return Inertia::render('Administrasi/Material');
})->name('admin-material');



});

// Route::get('/forgot-password', function () {
//     return view('auth.forgot-password');
// })->middleware('guest')->name('password.request');

require __DIR__.'/auth.php';

// Route::get('send-testing-mail', function() {
//     $data = [
//     'email' => 'contoh@email.com',
//     'password' => 123
//     ];
//     Mail::to('aaa@email.com')->send(new TestMail($data));
// });