<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Mail\TestMail;
use Illuminate\Container\Attributes\Auth;

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

Route::get('/logout', function () {
    return Inertia::render('Auth/Login');
})->name('logout');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
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