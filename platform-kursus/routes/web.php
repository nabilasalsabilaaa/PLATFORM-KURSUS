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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;

// public
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/courses/catalog', [PublicCourseController::class, 'index'])
    ->name('courses.catalog');

Route::get('/courses/{course}/detail', [PublicCourseController::class, 'show'])
    ->name('courses.detail');

Route::get('/courses/{course}', [PublicCourseController::class, 'show'])
    ->name('courses.show');
    

// auth/profile
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// course (adm/teach)
Route::middleware(['auth', 'role:admin,teacher'])
    ->prefix('dashboard')
    ->group(function () {
        Route::resource('courses', CourseController::class);
    });

Route::middleware(['auth', 'role:teacher'])
    ->get('/dashboard/my-courses', [CourseController::class, 'index'])
    ->name('teacher.courses.index');

// categori (adm)
Route::middleware(['auth', 'role:admin'])
    ->prefix('dashboard')
    ->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
    });

//content (adm/teach)
Route::middleware(['auth', 'role:admin,teacher'])->group(function () {
    Route::get('courses/{course}/contents', [ContentController::class, 'index'])
        ->name('contents.index');

    Route::get('courses/{course}/contents/create', [ContentController::class, 'create'])
        ->name('contents.create');

    Route::post('courses/{course}/contents', [ContentController::class, 'store'])
        ->name('contents.store');

    Route::get('courses/{course}/contents/{content}/edit', [ContentController::class, 'edit'])
        ->name('contents.edit');

    Route::put('courses/{course}/contents/{content}', [ContentController::class, 'update'])
        ->name('contents.update');

    Route::delete('courses/{course}/contents/{content}', [ContentController::class, 'destroy'])
        ->name('contents.destroy');

    Route::get('/teacher/courses/{course}/students', [TeacherProfileController::class, 'courseStudents'])
        ->name('teacher.courses.students');
});

//enroll/lesson (stud)
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])
        ->name('courses.enroll');

    Route::delete('/courses/{course}/enroll', [EnrollmentController::class, 'destroy'])
        ->name('courses.unenroll');

    Route::get('/courses/{course}/lessons/{content}', [LessonController::class, 'show'])
        ->name('lessons.show');

    Route::post('/courses/{course}/lessons/{content}/done', [LessonController::class, 'markAsDone'])
        ->name('lessons.done');

    Route::post('/courses/{course}/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');
});

//profil (stud/teach)
Route::middleware(['auth', 'role:student'])
    ->get('/profile/student', [StudentProfileController::class, 'index'])
    ->name('profile.student');

Route::middleware(['auth', 'role:teacher'])->group(function () {
});

//user manage (adm)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
});

require __DIR__ . '/auth.php';