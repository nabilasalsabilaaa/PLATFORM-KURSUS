<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\PublicCourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\TeacherProfileController;
use App\Http\Controllers\UserController;

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

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])
        ->name('courses.enroll');

    Route::delete('/courses/{course}/enroll', [EnrollmentController::class, 'destroy'])
        ->name('courses.unenroll');
});

Route::get('/courses/catalog', [PublicCourseController::class, 'index'])
    ->name('courses.catalog');

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])
        ->name('courses.enroll');

    Route::delete('/courses/{course}/enroll', [EnrollmentController::class, 'destroy'])
        ->name('courses.unenroll');
});


Route::middleware(['auth', 'role:student'])->group(function () {

    Route::get('/courses/{course}/lessons/{content}', [LessonController::class, 'show'])
        ->name('lessons.show');

    Route::post('/courses/{course}/lessons/{content}/done', [LessonController::class, 'markAsDone'])
        ->name('lessons.done');
});

Route::middleware(['auth','role:student'])
    ->get('/profile/student', [StudentProfileController::class, 'index'])
    ->name('profile.student');



Route::middleware(['auth', 'role:teacher'])
    ->get('/profile/teacher', [TeacherProfileController::class, 'index'])
    ->name('profile.teacher');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
});
