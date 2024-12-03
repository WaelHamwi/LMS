<?php
namespace App\Http\Traits;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;

trait HandlesAttendance
{
    public function storeAttendance(Request $request)
    {
        try {
          
            foreach ($request->attendance as $studentId => $attendanceData) {
                $attendanceStatusBoolean = ($attendanceData['status'] === 'present');
                $student = Student::findOrFail($studentId);

                $existingAttendance = Attendance::where('student_id', $studentId)
                    ->whereDate('attendance_date', now()->format('Y-m-d'))
                    ->first();

                if ($existingAttendance) {
                    $existingAttendance->update([
                        'attendance_status' => $attendanceStatusBoolean,
                        'teacher_id' => $request->teacher_id ?? 1,
                    ]);
                } else {
                    Attendance::create([
                        'student_id' => $studentId,
                        'academic_level_id' => $student->academic_level_id,
                        'classroom_id' => $student->classroom_id,
                        'section_id' => $student->section_id,
                        'teacher_id' => $request->teacher_id ?? 1,
                        'attendance_date' => now()->format('Y-m-d'),
                        'attendance_status' => $attendanceStatusBoolean,
                    ]);
                }
            }

            toastr()->success('Attendance has been taken');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
