<?php

namespace App\Repositories\Teacher;

use App\Models\AcademicLevel;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Traits\StoresExams;

class ExamRepository implements ExamRepositoryInterface
{
    use StoresExams;
    public function index()
    {
        $academicLevels = AcademicLevel::all();
        $classrooms = Classroom::all();
        $teachers = Teacher::all();
        $sections = Section::all();
        $subjects = Subject::all();
        $exams = Exam::all();
        return view('Teachers.Exams', compact('exams', 'academicLevels', 'classrooms', 'sections', 'teachers', 'subjects'));
    }

    public function create()
    {
        $data['academic_levels'] = AcademicLevel::all();
        $data['subjects'] = Subject::all();
        $data['teachers'] = Teacher::all();
        return view('Exam.create', $data);
    }



    public function store($request)
    {
        $validatedData = $request->validated();

        $validatedData['teacher_id'] = array_map(
            fn($index) => $request->teacher_id[$index] ?? 1,
            array_keys($validatedData['subject_id'])
        );

        try {
            $this->storeExams($validatedData, Exam::class);

            toastr()->success('The exams have been added successfully.');
            return redirect()->route('exams.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validated();

        try {
            $exam = Exam::findOrFail($id);
            $exam->update([
                'name' => $validatedData['name'][0] ?? $validatedData['name'],
                'subject_id' => $validatedData['subject_id'][0] ?? $validatedData['subject_id'],
                'academic_level_id' => $validatedData['academic_level_id'][0] ?? $validatedData['academic_level_id'],
                'classroom_id' => $validatedData['classroom_id'][0] ?? $validatedData['classroom_id'],
                'section_id' => $validatedData['section_id'][0] ?? $validatedData['section_id'],
            ]);

            toastr()->success('The exam has been updated successfully.');
            return redirect()->route('exams.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }




    public function destroy($request)
    {
        try {
            Exam::destroy($request->id);
            toastr()->error('the exam has been deleted');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
