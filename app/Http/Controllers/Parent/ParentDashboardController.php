<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentDashboardController extends Controller
{
    public function showStudentResults($studentId)
    {
        $student = Student::findOrFail($studentId);
        $marks = \DB::table('student_question_marks')
            ->leftJoin('exams', 'student_question_marks.exam_id', '=', 'exams.id')
            ->where('student_question_marks.student_id', $studentId)
            ->select('student_question_marks.*', 'exams.name as exam_name')
            ->get();

        return view('parentData.student_results', compact('student', 'marks'));
    }
    public function getStudentsResults($parentId)
    {
        $students = Student::where('parent_id', $parentId)->get();

        $studentResults = \DB::table('student_question_marks')
            ->leftJoin('students', 'student_question_marks.student_id', '=', 'students.id')
            ->leftJoin('exams', 'student_question_marks.exam_id', '=', 'exams.id')
            ->whereIn('student_question_marks.student_id', $students->pluck('id')) // Get results only for the students related to the parent
            ->select('student_question_marks.*', 'exams.name as exam_name', 'students.name as student_name')
            ->get();

        return view('parentData.students_results', compact('studentResults'));
    }
    public function historyReportAttendance(Request $request)
    {
        $parentId = Auth::user()->id;
        $students = Student::where('parent_id', $parentId)->get();
        $allStudents = Student::all();


        return view('parentData.attendanceHistory', compact('students','allStudents'));
    }
    public function getHistoryReportAttendance(Request $request)
    {
        try {

            $parentId = Auth::guard('parent')->user()->id;
            $allStudents = Student::where('parent_id', $parentId)->get();
            $students = Student::where('parent_id', $parentId)
                ->when($request->has('student_id') && $request->student_id, function ($query) use ($request) {
                    $query->where('id', $request->student_id);
                })
                ->with(['attendance' => function ($query) use ($request) {
                    if ($request->has('attendance_date') && $request->attendance_date) {
                        $query->where('attendance_date', $request->attendance_date);
                    }
                }])
                ->get();

            return view('parentData.attendanceHistory', compact('students', 'allStudents'))
                ->with('success', 'Attendance history successfully retrieved.');
        } catch (\Exception $e) {
            // Return an error message if something goes wrong
            return redirect()->route('parent.getHistoryReportAttendance')
                ->with('error', 'An error occurred while retrieving the attendance history. Please try again later.');
        }
    }
    public function feeInvoices(Request $request)
    {
        $parentId = auth()->user()->id;

        $students = Student::where('parent_id', $parentId)
            ->with('feeInvoices')
            ->get();

        // Fetch student accounts with calculated balance (debit - credit)
        $studentAccounts = \DB::table('student_accounts')
            ->join('students', 'student_accounts.student_id', '=', 'students.id')
            ->where('students.parent_id', $parentId)
            ->select(
                'student_accounts.id',
                'student_accounts.date',
                'student_accounts.type',
                'student_accounts.fee_invoice_id',
                'student_accounts.receipt_id',
                'student_accounts.payment_id',
                'student_accounts.processing_id',
                'student_accounts.student_id',
                'student_accounts.debit',
                'student_accounts.credit',
                'student_accounts.description',
                'student_accounts.created_at',
                'student_accounts.updated_at',
                \DB::raw('SUM(student_accounts.debit - student_accounts.credit) OVER (PARTITION BY student_accounts.student_id ORDER BY student_accounts.date ASC) as balance') // Cumulative balance
            )
            ->orderBy('student_accounts.date', 'desc')
            ->get();

        return view('parentData.fee_invoices', compact('students', 'studentAccounts'));
    }


    public function getProfile()
    {
        try {
            $parent = Auth::user();

            return view('parentData.myProfile', compact('parent'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
