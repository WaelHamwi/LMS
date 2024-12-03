<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Classroom\ClassroomsController;
use App\Http\Controllers\Section\SectionsController;
use App\Http\Controllers\BulkDelete\BulkDeleteQuestionController;
use App\Http\Controllers\Teacher\QuestionController;
use App\Http\Controllers\Image\ImageController;
use App\Http\Controllers\Student\StudentsController;

Route::middleware(['multi_guard'])->group(function () {
    Route::get('/classrooms/by-academic-level', [ClassroomsController::class, 'getClassroomsByAcademicLevel'])->name('classrooms.byAcademicLevel');
    Route::resource('sections', SectionsController::class);
    Route::resource('questions', QuestionController::class);
    Route::delete('/questions-list/bulkDelete', [BulkDeleteQuestionController::class, 'bulkDelete'])->name('question.bulkDelete');
    Route::delete('/images/{id}', [ImageController::class, 'destroy'])->name('image.delete');
});
Route::middleware(['multi_guard_studentAdmin'])->group(function () {
    //image settings
    Route::post('/images', [ImageController::class, 'store'])->name('images.store');
    Route::get('/download-image/{id}', [ImageController::class, 'download'])->name('image.download');
    Route::delete('/images/{id}', [ImageController::class, 'destroy'])->name('image.delete');
    Route::put('/image/{id}', [ImageController::class, 'update'])->name('image.update');
    Route::resource('/students', StudentsController::class);
});
