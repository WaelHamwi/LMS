<?php

namespace App\Repositories\Student;

use App\Http\Requests\StoreStudents;
use App\Models\AcademicLevel;
use App\Models\Classroom;
use App\Models\Section;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\StudentAccount;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class StudentRepository implements StudentRepositoryInterface
{
    public function index(Request $request)
    {
        $classroomId = $request->input('classroom_id');
        /*  $studentsQuery = Student::with(['classroom', 'teachers']);

       if ($classroomId) {
            $studentsQuery->where('classroom_id', $classroomId);
        }

        $students = $studentsQuery->get();*/
        $academicLevels = AcademicLevel::all();
        $classrooms = Classroom::all();
        $sections = Section::all();
        $teachers = Teacher::all();
        $parents = StudentParent::all();
        $students = Student::all();
        $isEditMode = $request->has('edit') && $request->input('edit') == true;

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'classrooms' => $classrooms,
                'teachers' => $teachers,
            ]);
        }

        return view('students.index', compact('students', 'academicLevels', 'classrooms', 'sections', 'teachers', 'isEditMode', 'parents'));
    }

    public function create(StoreStudents $request) {}


    public function store(StoreStudents $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();
            $validatedData['password'] = Hash::make($validatedData['password']);

            $student = new Student($validatedData);

            if ($student->save()) {
                if ($request->hasFile('image')) {
                    foreach ($request->file('image') as $file) {
                        $timestamp = time();
                        $name = $timestamp . '_' . $file->getClientOriginalName();
                        $file->storeAs('attachments/students/' . $student->name, $name, 'upload_attachments');

                        $image = new Image();
                        $image->filename = $name;
                        $image->imageable_id = $student->id;
                        $image->imageable_type = 'App\Models\Student';
                        $image->save();
                    }
                }
                toastr()->success(__('The student has been added successfully.'));
            }

            DB::commit();
            return redirect()->route('students.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error(__('Failed to add the student: ') . $e->getMessage());
            return redirect()->route('students.index');
        }
    }





    public function show($id)
    {
        $student = Student::findOrFail($id);

        return view('students.show', compact('student'));
    }

    public function edit(Student $student) {}

    public function update(StoreStudents $request, Student $student)
    {
        try {
            $validatedData = $request->validated();
            if (isset($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            } else {
                unset($validatedData['password']);
            }
            $student->update($validatedData);

            toastr()->success(__('Student updated successfully.'));
            return redirect()->route('students.index');
        } catch (Exception $e) {
            toastr()->error(__('An error occurred: ') . $e->getMessage());
            return redirect()->back();
        }
    }


    public function destroy(Student $student)
    {
        try {
            $student->delete();
            return redirect()->route('students.index')->with('success', 'Student has been deleted successfully.');
        } catch (\Exception $e) {
            toastr()->error(__('Failed to delete the student: ') . $e->getMessage());
            return redirect()->route('students.index');
        }
    }

    public function bulkDelete(array $ids)
    {
        try {
            Student::whereIn('id', $ids)->delete();
            return redirect()->route('students.index')->with('success', 'Students have been deleted successfully.');
        } catch (\Exception $e) {
            toastr()->error(__('Failed to delete the student: ') . $e->getMessage());
            return redirect()->route('students.index');
        }
    }
    public function getStudentsBySection($sectionId)
    {
        $students = Cache::remember("students_section_{$sectionId}", 60 * 60, function () use ($sectionId) {
            return Student::where('section_id', $sectionId)->get();
        });

        if ($students->isEmpty()) {
            return response()->json(['message' => 'No students found for this section'], 404);
        }

        return response()->json(['students' => $students]);
    }
    public function getStudentBalance($studentId)
    {
        $totalDebit = StudentAccount::where('student_id', $studentId)->sum('debit');
        $totalCredit = StudentAccount::where('student_id', $studentId)->sum('credit');

        $balance =  $totalDebit - $totalCredit;

        return response()->json(['balance' => $balance]);
    }
}
