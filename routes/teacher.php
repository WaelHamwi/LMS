<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\BulkDelete\BulkDeleteExamController;
use App\Http\Controllers\Image\ImageController;
Route::middleware(['auth:teacher'])->group(function () {
    Route::view('/teacher/dashboard', 'Dashboard.teacher')->name('teacher.dashboard');
    Route::get('/teacher/students', [TeacherDashboardController::class, 'getStudents'])->name('teacher.students');
    Route::get('/teacher/sections', [TeacherDashboardController::class, 'getSections'])->name('teacher.sections');
    Route::post('/teacher/students/store', [TeacherDashboardController::class, 'store'])->name('teacher.attendance.store');
    Route::get('/teacher/report', [TeacherDashboardController::class, 'reportIndex'])->name('teacher.report');
    Route::get('/teacher/report-history', [TeacherDashboardController::class, 'historyReport'])->name('teacher.reportHistory');
    Route::get('/teacher/report/attendance', [TeacherDashboardController::class, 'getReport'])->name('teacher.getReport');
    Route::get('/teacher/exams', [TeacherDashboardController::class, 'getExam'])->name('teacher.exam');
    Route::post('/teacher/exams/store', [TeacherDashboardController::class, 'storeExam'])->name('teacherExams.storeExam');
    Route::delete('/teacher/{examId}', [TeacherDashboardController::class, 'destroy'])->name('teacherExams.destroy');
    Route::delete('/exams-list/bulkDelete', [BulkDeleteExamController::class, 'bulkDelete'])->name('exam.bulkDelete');
    Route::get('/teacher/questions', [TeacherDashboardController::class, 'getQuestions'])->name('teacher.questions');
    Route::get('/teacher/sessions', [TeacherDashboardController::class, 'getSessions'])->name('teacher.sessions');
    Route::post('/teacher/sessions', [TeacherDashboardController::class, 'storeSession'])->name('teacher_sessions.store');
    Route::post('/teacher/sessions/indirect', [TeacherDashboardController::class, 'storeIndirectSession'])->name('teacher_sessions.store_indirect_integration');
    Route::post('/teacher/sessions/indirect', [TeacherDashboardController::class, 'storeIndirectSession'])->name('teacher_sessions.store_indirect_integration');
    Route::delete('/teacher_sessions/{id}', [TeacherDashboardController::class, 'destroySession'])->name('teacher_sessions.destroySession');
    Route::get('/teacher/profile', [TeacherDashboardController::class, 'getProfile'])->name('teacher.profile');
    Route::get('/teacher-exams/{exam}/students-completed', [TeacherDashboardController::class, 'studentsCompleted'])->name('teacherExams.studentsCompleted');
    Route::post('/teacher/exams/{exam}/remake/{studentId}', [TeacherDashboardController::class, 'remakeExamForStudent'])->name('teacherExams.remakeExamForStudent');


    //image methods
    Route::put('/image-teacher/{id}', [ImageController::class, 'updateTeacherImage'])->name('image.updateTeacherImage');
    Route::post('/images-teachers', [ImageController::class, 'storeTeacherImage'])->name('images.storeTeacherImage');
    Route::get('/download-image-teacher/{id}', [ImageController::class, 'downloadTeacherImage'])->name('image.downloadTeacherImage');
});
