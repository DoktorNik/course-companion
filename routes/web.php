<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseFeedbackController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;
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

// search the app for all the things
Route::get('/search', [SearchController::class, 'find'])
    ->name('search.find')
    ->middleware(['auth', 'verified']);

Route::get('/findStudent', [StudentController::class, 'findStudent'])
    ->name('students.findStudent')
    ->middleware(['auth', 'verified']);

Route::get('/findCourse', [CourseController::class, 'findCourse'])
    ->name('courses.findCourse')
    ->middleware(['auth', 'verified']);

Route::get('/findCourseFeedback', [CourseFeedbackController::class, 'find'])
    ->name('courseFeedback.find')
    ->middleware(['auth', 'verified']);

Route::resource('students', StudentController::class)
    ->only(['index', 'show', 'store', 'create', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('courses', CourseController::class)
    ->only(['index', 'show', 'store', 'create', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::resource('courseFeedback', CourseFeedbackController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
