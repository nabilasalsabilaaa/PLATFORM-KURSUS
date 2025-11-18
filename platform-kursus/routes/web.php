<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentController;
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

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('courses', CourseController::class)->only([
        'index', 'create', 'store',
    ]);
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('dashboard')
    ->group(function () {
        Route::resource('categories', CategoryController::class);
});

Route::middleware(['auth', 'role:admin,teacher'])
    ->prefix('dashboard')
    ->group(function () {
        Route::resource('courses', CourseController::class);
    });

Route::middleware(['auth', 'role:admin,teacher'])->group(function () {

    Route::get('courses/{course}/contents', [ContentController::class, 'index'])->name('contents.index');
    Route::get('courses/{course}/contents/create', [ContentController::class, 'create'])->name('contents.create');
    Route::post('courses/{course}/contents', [ContentController::class, 'store'])->name('contents.store');

    Route::get('courses/{course}/contents/{content}/edit', [ContentController::class, 'edit'])->name('contents.edit');
    Route::put('courses/{course}/contents/{content}', [ContentController::class, 'update'])->name('contents.update');
    Route::delete('courses/{course}/contents/{content}', [ContentController::class, 'destroy'])->name('contents.destroy');

});

require __DIR__.'/auth.php';