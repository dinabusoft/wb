<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\MasterCustomerController;
use App\Http\Controllers\Api\MasterMaterialController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\UsersRoleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use Inertia\Inertia;
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

    Route::resource('devices',DeviceController::class);
    Route::resource('mastercustomers',MasterCustomerController::class);
    Route::resource('mastermaterials',MasterMaterialController::class);
    Route::resource('transactions',TransactionController::class);
    Route::resource('users',UserController::class);
    Route::resource('status',StatusController::class);

    Route::get('/master_materials/options', [MasterMaterialController::class, 'getOptions']);
    Route::get('/master_customers/options', [MasterCustomerController::class, 'getOptions']);
    Route::get('transactions/{transaction}/out',[TransactionController::class, 'showOut']);
    Route::put('/transactions/{transaction}/out', [TransactionController::class, 'saveOut'])->name('transactions.out');
    //Route::resource('usersroles',UsersRoleController::class);
    Route::get('/transactions-export',[TransactionController::class, 'export']);
});
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
    return Inertia::render('MasterCustomer/Index');
})->name('admin-customer');
     Route::get('/admin-material', function () {
    return Inertia::render('MasterMaterial/Index');
})->name('admin-material');


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
