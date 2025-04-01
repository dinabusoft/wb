<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\MasterCustomerController;
use App\Http\Controllers\Api\MasterMaterialController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UsersRoleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('devices',DeviceController::class);
    Route::resource('mastercustomers',MasterCustomerController::class);
    Route::resource('mastermaterials',MasterMaterialController::class);
    Route::resource('transactions',TransactionController::class);
    Route::resource('usersroles',UsersRoleController::class);
});

