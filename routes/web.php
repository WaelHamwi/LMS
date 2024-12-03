<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\LoginComponent;
use App\livewire\Auth\RegisterComponent;
use App\Http\Controllers\EmailVerification;
use App\Http\Controllers\Academic\AcademicLevelsController;
use App\Http\Controllers\BulkDelete\BulkDeleteFeeInvoicesController;
use App\Http\Controllers\BulkDelete\BulkDeleteFeesController;
use App\Http\Controllers\BulkDelete\BulkDeleteRecieptController;
use App\Http\Controllers\BulkDelete\BulkDeletePaymentFeeController;
use App\Http\Controllers\BulkDelete\BulkDeleteProcessingFeeController;
use App\Http\Controllers\BulkDelete\BulkDeleteSubjectController;
use App\Http\Controllers\BulkDelete\BulkDeleteExamController;
use App\Http\Controllers\BulkDelete\BulkDeleteQuestionController;
use App\Http\Controllers\BulkDelete\BulkDeleteLibraryController;
use App\Http\Controllers\Classroom\ClassroomsController;
use App\Http\Controllers\Section\SectionsController;
use App\Http\Controllers\Teacher\TeachersController;
use App\Http\Controllers\Student\StudentsController;
use App\Http\Controllers\Image\ImageController;
use App\Http\Controllers\Student\StudentPromotionController;
use App\Http\Controllers\Student\GraduatedController;
use App\Http\Controllers\Student\FeesController;
use App\Http\Controllers\Student\FeeInvoiceController;
use App\Http\Controllers\Student\ReceiptStudentController;
use App\Http\Controllers\Student\PaymentFeeStudentController;
use App\Http\Controllers\Student\ProcessFeeStudentController;
use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\Subject\SubjectController;
use App\Http\Controllers\Teacher\ExamController;
use App\Http\Controllers\Teacher\QuestionController;
use App\Http\Controllers\Zoom\OnlineSessionController;
use App\Http\Controllers\Library\LibraryController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\Home\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
  


    Route::view('dashboard', 'dashboard.admin')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
    Route::delete('/academic_levels/bulkDelete', [AcademicLevelsController::class, 'bulkDelete'])->name('academic_levels.bulkDelete');
    Route::get('/classrooms/by-academic-level', [ClassroomsController::class, 'getClassroomsByAcademicLevel'])->name('classrooms.byAcademicLevel');




    // Resource routes - defined after the custom routes
    Route::resource('academic_levels', AcademicLevelsController::class);
    Route::resource('classrooms', ClassroomsController::class);
    Route::resource('sections', SectionsController::class);

    //livewire paraents component
    Route::view('/student-parents', 'livewire.parent.student-parent-manager')->name('student.parents');
    Route::view('/add_parent', 'livewire.parent.show-add-parent')->name('add_parent');

    //teacher resource route
    Route::resource('/teachers', TeachersController::class);

    //student resource route and promotion routes
    Route::resource('/students', StudentsController::class);
    Route::get('/promotions', [StudentPromotionController::class, 'index'])->name('promotions.index');
    Route::post('/promotions/store', [StudentPromotionController::class, 'store'])->name('promotions.store');
    Route::get('/promotions/list', [StudentPromotionController::class, 'promoteList'])->name('promotions.list');
    Route::get('/student/academic-details', [StudentPromotionController::class, 'getStudentAcademicDetails'])->name('student.academicDetails');
    Route::delete('/promotions/{id}', [StudentPromotionController::class, 'destroy'])->name('promotions.destroy');
    Route::delete('/promotions/list/bulkDelete', [StudentPromotionController::class, 'bulkDelete'])->name('promotions.bulkDelete');
    Route::get('/students-available/by-section', [StudentsController::class, 'getStudentsBySection'])->name('students.bySection');
    Route::get('/students/{studentId}/balance', [StudentsController::class, 'getStudentBalance']);
    Route::resource('/receiptStudents', ReceiptStudentController::class);
    Route::resource('/paymentFeeStudents', PaymentFeeStudentController::class);
    Route::resource('/processingFeeStudents', ProcessFeeStudentController::class);

    //graduation resource route
    Route::resource('graduations', GraduatedController::class);

    //fees resource route
    Route::resource('fees', FeesController::class);

    //fees invoice 
    Route::resource('fee_invoices', FeeInvoiceController::class);

    //Attendance
    Route::resource('attendance', AttendanceController::class);
    Route::get('/attendance-sections/bySections', [AttendanceController::class, 'getAttendanceBySections'])->name('attendance.bySections');

    //subjects
    Route::resource('subjects', SubjectController::class);

    //exams
    Route::resource('exams', ExamController::class);

    //questions
    Route::resource('questions', QuestionController::class);

    //libraris
    Route::resource('libraries', LibraryController::class);
    Route::get('/libraries/{filename}', [LibraryController::class, 'download'])->name('libraries.download');


    //Zoom
    Route::resource('online_sessions', OnlineSessionController::class);
    Route::post('online_sessions/store_indirect_integration', [OnlineSessionController::class, 'storeIndirect'])
        ->name('online_sessions.store_indirect_integration');

    //bulk delete for models
    Route::delete('/sections/bulkDelete', [SectionsController::class, 'bulkDelete'])->name('sections.bulkDelete');
    Route::delete('/students/bulkDelete', [StudentsController::class, 'bulkDelete'])->name('students.bulkDelete');
    Route::delete('/graduations/bulkDelete', [GraduatedController::class, 'bulkDelete'])->name('graduations.bulkDelete');
    Route::delete('/classrooms/bulkDelete', [ClassroomsController::class, 'bulkDelete'])->name('classrooms.bulkDelete');
    Route::delete('/fees-students/bulkDelete', [BulkDeleteFeesController::class, 'bulkDelete'])->name('fees.bulkDelete');
    Route::delete('/fee-invoices/bulkDelete', [BulkDeleteFeeInvoicesController::class, 'bulkDelete'])->name('feeInvoices.bulkDelete');
    Route::delete('/receipt-students/bulkDelete', [BulkDeleteRecieptController::class, 'bulkDelete'])->name('receipt.bulkDelete');
    Route::delete('/paymentFee-students/bulkDelete', [BulkDeletePaymentFeeController::class, 'bulkDelete'])->name('payemntFee.bulkDelete');
    Route::delete('/processingFee-students/bulkDelete', [BulkDeleteProcessingFeeController::class, 'bulkDelete'])->name('processingFee.bulkDelete');
    Route::delete('/subjects-list/bulkDelete', [BulkDeleteSubjectController::class, 'bulkDelete'])->name('subject.bulkDelete');
    Route::delete('/exams-list/bulkDelete', [BulkDeleteExamController::class, 'bulkDelete'])->name('exam.bulkDelete');
    Route::delete('/questions-list/bulkDelete', [BulkDeleteQuestionController::class, 'bulkDelete'])->name('question.bulkDelete');
    Route::delete('/libraries-list/bulkDelete', [BulkDeleteLibraryController::class, 'bulkDelete'])->name('library.bulkDelete');
    //image settings
    Route::post('/images', [ImageController::class, 'store'])->name('images.store');
    Route::get('/download-image/{id}', [ImageController::class, 'download'])->name('image.download');
    Route::delete('/images/{id}', [ImageController::class, 'destroy'])->name('image.delete');
    Route::put('/image/{id}', [ImageController::class, 'update'])->name('image.update');

    // settings routes
    Route::get('settings', [SettingController::class, 'show'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('/localization-details', function () {
        return view('Settings.localization-details');
    });
    Route::get('/payment-settings', function () {
        return view('Settings.payment-settings');
    });
    Route::get('/email-settings', function () {
        return view('settings.email-settings');
    });
    Route::get('/social-links', function () {
        return view('settings.social-links');
    });
    Route::get('/seo-settings', function () {
        return view('settings.seo-settings');
    });
     // settings routes

     //debug env vars 
    /* Route::get('/debug-env', function () {
        dd([
            'MAIL_MAILER' => env('MAIL_MAILER'),
            'MAIL_HOST' => env('MAIL_HOST'),
            'MAIL_PORT' => env('MAIL_PORT'),
            'MAIL_USERNAME' => env('MAIL_USERNAME'),
            'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
            'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
            'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
        ]);
    });*/
    
   /* Route::get('/', function () {
        return redirect()->route('dashboard');
    });*/
    
    
});

/*auth system routes*/
Route::get('/', [HomeController::class, 'index'])->name('roles');
Route::get('/login', LoginComponent::class)->name('login');
Route::get('/register', RegisterComponent::class)->name('register');
Route::get('/verify-email/{token}', [EmailVerification::class, 'verify'])->name('verify.email');
Route::post('/resend-verification-email', [RegisterComponent::class, 'resendVerificationEmail'])->name('resendVerificationEmail');
Route::post('/logout', [Logout::class, 'logout'])->name('logout');

require __DIR__ . '/auth.php';
