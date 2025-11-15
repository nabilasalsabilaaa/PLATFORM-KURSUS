<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // resource course
    Route::resource('courses', CourseController::class)->only([
        'index', 'create', 'store',
        // nanti bisa tambah 'edit', 'update', 'destroy'
    ]);
});

Route::middleware(['auth', 'role:admin,teacher'])->group(function () {
    Route::resource('courses', CourseController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';