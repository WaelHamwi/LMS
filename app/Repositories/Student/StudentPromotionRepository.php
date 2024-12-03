<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Models\PromoteStudent;
use App\Models\AcademicLevel;
use App\Models\Classroom;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentPromotionRepository implements StudentPromotionRepositoryInterface
{
    public function index()
    {
        $academicLevels = AcademicLevel::all();
        $classrooms = Classroom::all();
        $sections = Section::all();
        $students = Student::all();

        return view('Students.promotions', compact('academicLevels', 'classrooms', 'sections', 'students'));
    }
    public function promoteList()
    {
        $promotedStudents = PromoteStudent::with([
            'student',
            'currentAcademicLevel',
            'currentClassroom',
            'currentSection',
            'newAcademicLevel',
            'newClassroom',
            'newSection'
        ])->get();

        $students = Student::all();
        $academicLevels = AcademicLevel::all();
        $classrooms = Classroom::all();
        $sections = Section::all();


        return view('Students.promoteList', compact('promotedStudents', 'students', 'academicLevels', 'classrooms', 'sections'));
    }


    public function store(Request $request)
    {

        if ($request->student_id) {
            $student_id = $request->input('student_id.0');
            $current_academic_level_id = $request->input('current_academic_level_id.0');
            $current_classroom_id = $request->input('current_classroom_id.0');
            $current_section_id = $request->input('current_section_id.0');
            $new_academic_level_id = $request->input('new_academic_level_id.0');
            $new_classroom_id = $request->input('new_classroom_id.0');
            $new_section_id = $request->input('new_section_id.0');
            $academic_year_id = $request->input('academic_year_id.0');

            $request->merge([
                'student_id' => $student_id,
                'current_academic_level_id' => $current_academic_level_id,
                'current_classroom_id' => $current_classroom_id,
                'current_section_id' => $current_section_id,
                'new_academic_level_id' => $new_academic_level_id,
                'new_classroom_id' => $new_classroom_id,
                'new_section_id' => $new_section_id,
                'academic_year_id' => $academic_year_id,
            ]);
        }

        $request->validate([
            'student_id' => 'sometimes|exists:students,id',
            'current_academic_level_id' => 'required|exists:academic_levels,id',
            'current_classroom_id' => 'required|exists:classrooms,id',
            'current_section_id' => 'required|exists:sections,id',
            'new_academic_level_id' => 'required|exists:academic_levels,id',
            'new_classroom_id' => 'required|exists:classrooms,id',
            'new_section_id' => 'required|exists:sections,id',
            'academic_year_id' => 'required|integer'
        ]);

        DB::beginTransaction();

        try {
            if ($request->student_id) {
                $student = Student::findOrFail($request->student_id);

                PromoteStudent::updateOrCreate(
                    [
                        'student_id' => $student->id,
                    ],
                    [
                        'current_academic_level_id' => $request->current_academic_level_id,
                        'current_classroom_id' => $request->current_classroom_id,
                        'current_section_id' => $request->current_section_id,
                        'new_academic_level_id' => $request->new_academic_level_id,
                        'new_classroom_id' => $request->new_classroom_id,
                        'new_section_id' => $request->new_section_id,
                        'old_academic_year_id' => $student->academic_year,
                        'new_academic_year_id' => $student->academic_year + 1
                    ]
                );

                $student->update([
                    'academic_level_id' => $request->new_academic_level_id,
                    'classroom_id' => $request->new_classroom_id,
                    'section_id' => $request->new_section_id,
                    'academic_year' => $student->academic_year + 1
                ]);
            } else {

                $students = Student::where('academic_level_id', $request->current_academic_level_id)
                    ->where('classroom_id', $request->current_classroom_id)
                    ->where('section_id', $request->current_section_id)
                    ->where('academic_year', $request->academic_year_id)
                    ->get();


                if ($students->isEmpty()) {
                    return back()->with('error', 'No students found for the given criteria.');
                }

                $oldAcademicYear = $students->first()->academic_year;

                foreach ($students as $student) {
                    PromoteStudent::updateOrCreate(
                        [
                            'student_id' => $student->id,
                        ],
                        [
                            'current_academic_level_id' => $request->current_academic_level_id,
                            'current_classroom_id' => $request->current_classroom_id,
                            'current_section_id' => $request->current_section_id,
                            'new_academic_level_id' => $request->new_academic_level_id,
                            'new_classroom_id' => $request->new_classroom_id,
                            'new_section_id' => $request->new_section_id,
                            'old_academic_year_id' => $oldAcademicYear,
                            'new_academic_year_id' => $oldAcademicYear + 1
                        ]
                    );

                    $student->update([
                        'academic_level_id' => $request->new_academic_level_id,
                        'classroom_id' => $request->new_classroom_id,
                        'section_id' => $request->new_section_id,
                        'academic_year' => $oldAcademicYear + 1
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('promotions.list')->with('success', 'Students promoted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to promote students. Error: ' . $e->getMessage());
        }
    }

    //get some details for the student academic and year 
    public function getStudentAcademicDetails(Request $request)
    {
        $student = Student::find($request->input('student_id'));

        if ($student) {
            return response()->json([
                'success' => true,
                'academic_level_id' => $student->academic_level_id,
                'academic_year' => $student->academic_year,
            ]);
        } else {
            return response()->json(['success' => false], 404);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $promotion = PromoteStudent::findOrFail($id);
            Student::where('id', $promotion->student_id)
                ->update([
                    'academic_level_id' => $promotion->current_academic_level_id,
                    'classroom_id' => $promotion->current_classroom_id,
                    'section_id' => $promotion->current_section_id,
                    'academic_year' => $promotion->old_academic_year_id,
                ]);

            PromoteStudent::destroy($id);

            DB::commit();
            return redirect()->route('promotions.list')->with('success', 'Student promoted is deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function bulkDelete(array $ids)
    {
        DB::beginTransaction();

        try {
            $promotions = PromoteStudent::whereIn('id', $ids)->get();

            foreach ($promotions as $promotion) {
                Student::where('id', $promotion->student_id)
                    ->update([
                        'academic_level_id' => $promotion->current_academic_level_id,
                        'classroom_id' => $promotion->current_classroom_id,
                        'section_id' => $promotion->current_section_id,
                        'academic_year' => $promotion->old_academic_year_id,
                    ]);
            }

            PromoteStudent::whereIn('id', $ids)->delete();

            DB::commit();
            return redirect()->route('promotions.list')->with('success', 'Students promoted are deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
