<?php

use App\Http\Controllers\Parent\ParentDashboardController;
use App\Models\Student;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Image\ImageController;

Route::middleware(['auth:parent'])->group(function () {

    Route::get('/parent/dashboard', function () {
        $parentId = Auth::guard('parent')->user()->id;
     
        $students = Student::where('parent_id', $parentId)->get();
        return view('Dashboard.parent', compact('students'));
    })->name('parent.dashboard');
    Route::get('parent/student/{studentId}/results', [ParentDashboardController::class, 'showStudentResults'])->name('parent.student.results');
    Route::get('/parent/{parentId}/students-results', [ParentDashboardController::class, 'getStudentsResults'])
    ->name('parent.students.results');
    Route::get('/parent/student/attendance', [ParentDashboardController::class, 'historyReportAttendance'])->name('parent.historyReportAttendance');
    Route::get('/parent/student/show-attendance', [ParentDashboardController::class, 'getHistoryReportAttendance'])->name('parent.getHistoryReportAttendance');
    Route::get('/parent/fee-invoices', [ParentDashboardController::class, 'feeInvoices'])->name('parent.feeInvoices');

    Route::get('/parent/profile', [ParentDashboardController::class, 'getProfile'])->name('parent.profile');
    Route::put('/image-parent/{id}', [ImageController::class, 'updateParentImage'])->name('image.updateParentImage');
    Route::post('/images-parents', [ImageController::class, 'storeParentImage'])->name('images.storeParentImage');
    Route::get('/download-image-parent/{id}', [ImageController::class, 'downloadParentImage'])->name('image.downloadParentImage');


});
