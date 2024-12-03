<?php

namespace App\Repositories\Teacher;

use App\Models\Question;
use App\Models\Exam;
use App\Repositories\Teacher\QuestionRepositoryInterface;
use Illuminate\Http\Request;

class QuestionRepository implements QuestionRepositoryInterface
{
    public function index()
    {
        $questions = Question::with('exam')->get();
        $exams = Exam::get();
        return view('Teachers.Questions', compact('questions', 'exams'));
    }

    public function store(Request $request)
    {
        try {
            foreach ($request->input('question_text') as $index => $questionText) {
                $answers = explode("\r\n", $request->input('answers')[$index]);
                Question::create([
                    'question_text' => $questionText,
                    'answers' => json_encode($answers),
                    'correct_answer' => $request->input('correct_answer')[$index],
                    'score' => $request->input('score')[$index],
                    'exam_id' => $request->input('exam_id')[$index],
                ]);
            }
            toastr()->success('The questions have been added successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function show($id)
    {
        $quizz_id = $id;
        return view('pages.Teachers.dashboard.Questions.create', compact('quizz_id'));
    }


    public function update(Request $request, $id)
    {
        try {
            $question = Question::findOrFail($id);
            $answers = explode("\r\n", $request->input('answers.0'));
            $question->update([
                'question_text' => $request->input('question_text.0'),
                'answers' => $answers,
                'correct_answer' => $request->input('correct_answer.0'),
                'score' => $request->input('score.0'),
                'exam_id' => $request->input('exam_id.0'),
            ]);
            toastr()->success('The question has been updated successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    

    public function destroy($id)
    {
        try {
            Question::destroy($id);
            toastr()->error('The question has been deleted');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
