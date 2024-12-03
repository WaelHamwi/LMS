<?php

namespace App\Http\Controllers\Student;



use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function getExams()
    {
        $studentId = Auth::user()->id;
        $student = Student::findOrFail($studentId);
        $sectionId = $student->section_id;
        $exams = Exam::where('section_id', $sectionId)->get();
        $marksData = [];
        foreach ($exams as $exam) {
            $exam->examDone = \DB::table('student_question_marks')
                ->where('exam_id', $exam->id)
                ->where('student_id', $studentId)
                ->exists();

            if ($exam->examDone) {
                $marksObtained = \DB::table('student_question_marks')
                    ->where('exam_id', $exam->id)
                    ->where('student_id', $studentId)
                    ->sum('marks_obtained');
                $totalMarks = \DB::table('student_question_marks')
                    ->where('exam_id', $exam->id)
                    ->where('student_id', $studentId)
                    ->sum('total_marks');
                $cheatingStatus = \DB::table('student_question_marks')
                    ->where('exam_id', $exam->id)
                    ->where('student_id', $studentId)
                    ->value('cheating_status');

                $marksData[$exam->id] = [
                    'marks_obtained' => $marksObtained,
                    'total_marks' => $totalMarks,
                    'cheating_status' => $cheatingStatus, 
                ];
            }
        }


        return view('studentData.myExams', compact('exams', 'marksData'));
    }
    public function showExam($id)
    {
        $exam = Exam::findOrFail($id);
        $studentId = Auth::user()->id;
        $studentName = Student::findOrFail($studentId);

        return view('studentData.showExam', compact('exam', 'studentId'));
    }
}
