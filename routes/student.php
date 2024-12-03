<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Image\ImageController;
use App\Http\Controllers\Student\StudentsController;

Route::middleware(['auth:student'])->group(function () {
    Route::view('/student/dashboard', 'Dashboard.student')->name('student.dashboard');
    Route::get('/student/exams', [StudentDashboardController::class, 'getExams'])->name('student.exams');
    Route::get('/student/exam/{id}', [StudentDashboardController::class, 'showExam'])->name('exams.showExam');
});
