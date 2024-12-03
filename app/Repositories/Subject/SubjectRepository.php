<?php

namespace App\Repositories\Subject;

use App\Models\Subject;
use App\Models\AcademicLevel;
use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Http\Request;


class SubjectRepository implements SubjectRepositoryInterface
{
    public function index()
    {
        $subjects = Subject::all();

        $academicLevels = AcademicLevel::all();
        $classrooms = Classroom::all();
        $teachers = Teacher::all();

        return view('Subjects.index', compact('subjects', 'academicLevels', 'classrooms', 'teachers'));
    }

    public function show($id)
    {
        $subject = Subject::with(['academicLevel', 'classroom', 'teacher'])->findOrFail($id);
        return view('Subject.show', compact('subject'));
    }

    public function store(Request $request)
    {
        try {
            $names = $request->name;
            $academic_level_ids = $request->academic_level_id;
            $classroom_ids = $request->classroom_id;
            $teacher_ids = $request->teacher_id;

            foreach ($names as $index => $name) {
                Subject::create([
                    'name' => $name,
                    'academic_level_id' => $academic_level_ids[$index],
                    'classroom_id' => $classroom_ids[$index],
                    'teacher_id' => $teacher_ids[$index],
                ]);
            }

            toastr()->success('Subjects have been added successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $subject->update([
                'name' => $request->name[0] ?? $subject->name,
                'academic_level_id' => $request->academic_level_id[0] ?? $subject->academic_level_id,
                'classroom_id' => $request->classroom_id[0] ?? $subject->classroom_id,
                'teacher_id' => $request->teacher_id[0] ?? $subject->teacher_id,
            ]);

            toastr()->success('Subject has been updated successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $subject->delete();

            toastr()->success('Subject has been deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
