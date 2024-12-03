<?php

namespace App\Repositories\Attendance;

use App\Models\AcademicLevel;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Http\Traits\HandlesAttendance;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    use HandlesAttendance;
    public function index()
    {
        $students = Student::with(['attendance' => function ($query) {
            $query->orderBy('attendance_date');
        }])->get();
        $academicLevels = AcademicLevel::with(['Sections'])->get();
        $listAcademicLevels = AcademicLevel::all();
        $teachers = Teacher::all();
        return view('Attendance.index', compact('academicLevels', 'listAcademicLevels', 'teachers', 'students'));
    }
    public function getAttendanceBySections(Request $request)
{
    try {
        $sections = Cache::remember('sections_list', 60, function () {
            return Section::get(['id', 'name']);
        });

        return response()->json($sections);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to retrieve sections'], 500);
    }
}
    public function show($id)
    {
        $students = Student::with('attendance')->where('section_id', $id)->get();
        return view('Attendance.section', compact('students'));
    }

    public function store(Request $request)
    {
        return $this->storeAttendance($request);
    }



    public function update($request)
    {
        // TODO: Implement update() method.
    }

    public function destroy($request)
    {
        // TODO: Implement destroy() method.
    }
}
