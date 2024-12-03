<?php

namespace App\Repositories\student;

use App\Models\AcademicLevel;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Section;
use Illuminate\Support\Facades\Log;

class StudentGraduatedRepository implements StudentGraduatedRepositoryInterface
{
    public function bulkIndex()
    {
        try {
            $academicLevels = AcademicLevel::all();
            $classrooms = Classroom::all();
            $sections = Section::all();

            return view('Students.bulkGraduations', compact('academicLevels', 'classrooms', 'sections'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch bulk index data: ' . $e->getMessage());
            return redirect()->back()->with('error', __('Failed to load data. Please try again.'));
        }
    }

    public function bulkStore(array $request)
    {
        try {
            $validatedData = validator()->make($request, [
                'current_academic_level_id' => 'required|exists:academic_levels,id',
                'current_classroom_id' => 'required|exists:classrooms,id',
                'current_section_id' => 'required|exists:sections,id',
            ])->validate();

            $students = Student::where('academic_level_id', intval($validatedData['current_academic_level_id']))
                ->where('classroom_id', intval($validatedData['current_classroom_id']))
                ->where('section_id', intval($validatedData['current_section_id']))
                ->get();
            if ($students->isEmpty()) {
                return redirect()->back()->with('error', __('There are no students to graduate with the selected criteria.'));
            }

            foreach ($students as $student) {
                Student::destroy($student->id);
                $student->promotions()->update(['deleted_at' => now()]);
            }

            return redirect()->route('graduations.index')->with('success', 'Students graduated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to bulk store students: ' . $e->getMessage());
            return redirect()->back()->with('error', __('Failed to graduate students. Please try again.'));
        }
    }

    public function index()
    {
        try {
            $academicLevels = AcademicLevel::all();
            $classrooms = Classroom::all();
            $sections = Section::all();
            $students = Student::all();
            $graduatedStudents = Student::onlyTrashed()->get();
            return view('Students.Graduation', compact('academicLevels', 'classrooms', 'sections', 'students', 'graduatedStudents'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch index data: ' . $e->getMessage());
            return redirect()->back()->with('error', __('Failed to load data. Please try again.'));
        }
    }

    public function create()
    {
        try {
            $Academic = AcademicLevel::all();
            return view('Studentss.Graduated.create', compact('grades'));
        } catch (\Exception $e) {
            Log::error('Failed to create graduation view: ' . $e->getMessage());
            return redirect()->back()->with('error', __('Failed to load create view. Please try again.'));
        }
    }

    public function store(array $request)
    {
        try {

            $student_id = $request['student_id'][0] ?? null;
            $academic_level_id = $request['academic_level_id'][0] ?? null;
            $classroom_id = $request['classroom_id'][0] ?? null;
            $section_id = $request['section_id'][0] ?? null;

            $request['student_id'] = $student_id;
            $request['academic_level_id'] = $academic_level_id;
            $request['classroom_id'] = $classroom_id;
            $request['section_id'] = $section_id;
            //  dd($request);
            $student = Student::where('academic_level_id', $request['academic_level_id'])
                ->where('classroom_id', $request['classroom_id'])
                ->where('section_id', $request['section_id'])
                ->where('id', $request['student_id'])
                ->first();

            if (!$student) {
                return redirect()->back()->with('error_Graduated', __('There is no student to make the graduation.'));
            }
            $student->promotions()->update(['deleted_at' => now()]);
            $student->delete();

            return redirect()->route('graduations.index')->with('success', 'Student has graduated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to store student graduation: ' . $e->getMessage());
            return redirect()->back()->with('error', __('Failed to graduate student. Please try again.'));
        }
    }


    public function SoftDelete($request)
    {
        try {
        } catch (\Exception $e) {
            Log::error('Failed to soft delete student: ' . $e->getMessage());
            return redirect()->back()->with('error', __('Failed to perform soft delete. Please try again.'));
        }
    }

    public function ReturnData($id)
    {

        try {
            $student = Student::onlyTrashed()->where('id', $id)->first();

            if ($student) {
                $student->restore();
                $student->promotions()->withTrashed()->restore();
                return redirect()->route('graduations.index')->with('success', 'Student graduation is undone successfully.');
            } else {
                return redirect()->back()->with('error', __('Student not found.'));
            }
        } catch (\Exception $e) {
            Log::error('Failed to return data for student ID ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', __('Failed to undo graduation. Please try again.'));
        }
    }


    public function destroy($id)
    {
        try {
            $student = Student::onlyTrashed()->where('id', $id)->first();
            $student->promotions()->forceDelete();
            $student->forceDelete();
            return redirect()->route('graduations.index')->with('success', 'Student has been deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete student ID ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', __('Failed to delete student. Please try again.'));
        }
    }

    public function show()
    {
        try {
            $academicLevels = AcademicLevel::all();
            $classrooms = Classroom::all();
            $sections = Section::all();

            return view('graduations.bulk', compact('academicLevels', 'classrooms', 'sections'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch show data: ' . $e->getMessage());
            return redirect()->back()->with('error', __('Failed to load data. Please try again.'));
        }
    }

    public function update($id, array $data)
    {
        try {
        } catch (\Exception $e) {
            Log::error('Failed to update student ID ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', __('Failed to update student. Please try again.'));
        }
    }
    public function bulkDelete(array $ids)
    {
        try {
            $students = Student::onlyTrashed()->whereIn('id', $ids)->get();
            if ($students->isNotEmpty()) {
                foreach ($students as $student) {
                    $student->restore();
                    $student->promotions()->withTrashed()->restore();
                }
                return redirect()->route('graduations.index')->with('success', 'Selected students and their related data have been restored successfully.');
            } else {
                return redirect()->back()->with('error', __('No students found for the provided IDs.'));
            }
        } catch (\Exception $e) {
            Log::error('Failed to return data for student IDs ' . implode(', ', $ids) . ': ' . $e->getMessage());
            return redirect()->back()->with('error', __('Failed to undo graduation. Please try again.'));
        }
    }
}
