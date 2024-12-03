<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Academic\AcademicLevelRepository;
use App\Repositories\Academic\AcademicLevelRepositoryInterface;
use App\Repositories\Classroom\ClassroomRepository;
use App\Repositories\Classroom\ClassroomRepositoryInterface;
use App\Repositories\Section\SectionRepository;
use App\Repositories\Section\SectionRepositoryInterface;
use App\Repositories\Teacher\TeacherRepository;
use App\Repositories\Teacher\TeacherRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Student\StudentRepository;
use App\Repositories\student\StudentPromotionRepositoryInterface;
use App\Repositories\student\StudentPromotionRepository;
use App\Repositories\student\StudentGraduatedRepository;
use App\Repositories\student\StudentGraduatedRepositoryInterface;
use App\Repositories\student\FeesRepositoryInterface;
use App\Repositories\student\FeesRepository;
use App\Repositories\student\FeeInvoiceRepositoryInterface;
use App\Repositories\student\FeeInvoiceRepository;
use App\Repositories\Student\ReceiptStudentRepositoryInterface;
use App\Repositories\Student\ReceiptStudentRepository;
use App\Repositories\Student\PaymentFeeStudentRepository;
use App\Repositories\Student\PaymentFeeStudentRepositoryInterface;
use App\Repositories\Student\ProcessFeeStudentRepository;
use App\Repositories\Student\ProcessFeeStudentRepositoryInterface;
use App\Repositories\Attendance\AttendanceRepository;
use App\Repositories\Attendance\AttendanceRepositoryInterface;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\Teacher\ExamRepository;
use App\Repositories\Teacher\ExamRepositoryInterface;
use App\Repositories\Teacher\QuestionRepositoryInterface;
use App\Repositories\Teacher\QuestionRepository;
use App\Repositories\Library\LibraryRepositoryInterface;
use App\Repositories\Library\LibraryRepository;






class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $bindings = [
            AcademicLevelRepositoryInterface::class => AcademicLevelRepository::class,
            ClassroomRepositoryInterface::class => ClassroomRepository::class,
            SectionRepositoryInterface::class => SectionRepository::class,
            TeacherRepositoryInterface::class => TeacherRepository::class,
            StudentRepositoryInterface::class => StudentRepository::class,
            StudentPromotionRepositoryInterface::class => StudentPromotionRepository::class,
            StudentGraduatedRepositoryInterface::class => StudentGraduatedRepository::class,
            FeesRepositoryInterface::class => FeesRepository::class,
            FeeInvoiceRepositoryInterface::class => FeeInvoiceRepository::class,
            ReceiptStudentRepositoryInterface::class => ReceiptStudentRepository::class,
            PaymentFeeStudentRepositoryInterface::class => PaymentFeeStudentRepository::class,
            ProcessFeeStudentRepositoryInterface::class => ProcessFeeStudentRepository::class,
            AttendanceRepositoryInterface::class => AttendanceRepository::class,
            SubjectRepositoryInterface::class => SubjectRepository::class,
            ExamRepositoryInterface::class => ExamRepository::class,
            QuestionRepositoryInterface::class => QuestionRepository::class,
            LibraryRepositoryInterface::class => LibraryRepository::class,

        ];

        foreach ($bindings as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // This method can be used for bootstrapping services, if needed
    }
}
