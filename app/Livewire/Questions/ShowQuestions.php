<?php

namespace App\Livewire\Questions;

use App\Models\Question;
use Livewire\Component;
use App\Models\Student;

class ShowQuestions extends Component
{
    public $exam;
    public $studentId;
    public $questions;
    //live wire properties
    public $currentQuestionIndex = 0;
    public $studentName;
    public $selectedAnswer = null;

    public function mount($exam, $studentId)
    {
        //data passed through the normal controller and blade
        $this->exam = $exam;
        $this->studentId = $studentId;
        $student = Student::find($this->studentId);
        $this->studentName = $student ? $student->name : 'Unknown';
        $this->questions = Question::where('exam_id', $this->exam->id)->get();
    }
    public function render()
    {
        $examId = $this->exam->id;
        $questions = Question::where('exam_id', $examId)->get();
        $currentQuestionIndex = $this->currentQuestionIndex;
        return view('livewire.questions.show-questions', compact('currentQuestionIndex'));
    }
    public function nextQuestion($questionId, $correctAnswer, $score)
    {
        $marksObtained = ($this->selectedAnswer == $correctAnswer) ? $score : 0;

        \DB::table('student_question_marks')->insert([
            'student_id' => $this->studentId,
            'exam_id' => $this->exam->id,
            'question_id' => $questionId,
            'marks_obtained' => $marksObtained,
            'total_marks' => $score,
            'cheating_status' => 'none',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
            $this->selectedAnswer = null;
        } else {
            toastr()->success('Exam completed successfully.');
            return redirect()->route('student.exams');
        }
    }
    public function markCheating($questionId)
    {
        if ($this->currentQuestionIndex >= count($this->questions) - 1) {
            return;
        }
        \DB::table('student_question_marks')->insert([
            'student_id' => $this->studentId,
            'exam_id' => $this->exam->id,
            'question_id' => $questionId, 
            'marks_obtained' => 0,
            'total_marks' => 0, 
            'cheating_status' => 'suspected',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        toastr()->error('Cheating has been detected. Your score has been set to zero.');


        return redirect()->route('student.exams');
    }
}
