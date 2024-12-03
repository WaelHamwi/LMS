<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\HandlesAttendance;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Section;
use App\Models\AcademicLevel;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\OnlineSession;
use App\Http\Traits\StoresExams;
use Illuminate\Support\Facades\DB;
use App\Helpers\Zoom\ZoomHelper;
use Illuminate\Support\Facades\Http;

class TeacherDashboardController extends Controller
{
    use StoresExams;
    use HandlesAttendance;
    private function getSectionsWithStudents()
    {
        $teacher = Auth::user();
        return $teacher->sections()->with(['students.todayAttendance'])->get();
    }

    public function getStudents()
    {
        $sections = $this->getSectionsWithStudents();
        $students = $sections->flatMap(fn($section) => $section->students);
        return view('teacherData.students', compact('students', 'sections'));
    }

    public function reportIndex()
    {
        $teacher = Auth::user();
        $sections = $this->getSectionsWithStudents();
        $students = $sections->flatMap(fn($section) => $section->students);
        $students->each(function ($student) {
            $student->load('attendance');
        });

        return view('teacherData.report', compact('students'));
    }
    public function getSections()
    {
        $teacher = Auth::user();
        $sections = $teacher->sections()->with('students')->get();

        return view('teacherData.sections', compact('sections'));
    }
    public function store(Request $request)
    {
        return $this->storeAttendance($request);
    }
    public function historyReport(Request $request)
    {
        $teacher = Auth::user();
        $sections = $this->getSectionsWithStudents();
        $students = $sections->flatMap(fn($section) => $section->students);

        if ($request->has('student_id')) {
            $students = $students->where('id', $request->student_id);
        }

        if ($request->has('attendance_date')) {
            $students->each(function ($student) use ($request) {
                $student->attendance = $student->attendance->where('attendance_date', $request->attendance_date);
            });
        }
        $students->each(function ($student) {
            $student->load('attendance');
        });

        return view('teacherData.historyReport', compact('students'));
    }


    public function getReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ], [
            'end_date.after_or_equal' => 'The end date must be greater than or equal to the start date.',
        ]);

        $studentsQuery = Student::query();

        if ($request->has('student_id') && $request->student_id) {
            $studentsQuery->where('id', $request->student_id);
        }

        if ($request->has('start_date') && $request->start_date && $request->has('end_date') && $request->end_date) {
            $studentsQuery->whereHas('attendance', function ($query) use ($request) {
                $query->whereBetween('attendance_date', [$request->start_date, $request->end_date]);
            });
        }

        $students = $studentsQuery->with('attendance')->get();

        return view('teacherData.historyReport', compact('students'));
    }
    public function getExam()
    {
        $teacher = Auth::user();

        $teacherSections = DB::table('teacher_section')->where('teacher_id', $teacher->id)->get();
        $sectionIds = $teacherSections->pluck('section_id');

        $sections = Section::whereIn('id', $sectionIds)->get();
        $academicLevels = AcademicLevel::whereIn('id', $sections->pluck('academic_level_id'))->get();
        $classrooms = Classroom::whereIn('id', $sections->pluck('classroom_id'))->get();

        $exams = Exam::whereIn('section_id', $sectionIds)->get();
        $subjects = Subject::whereIn('classroom_id', $classrooms->pluck('id'))
            ->whereIn('academic_level_id', $academicLevels->pluck('id'))
            ->where('teacher_id', $teacher->id)
            ->get();

        return view('teacherData.myExam', compact('exams', 'academicLevels', 'classrooms', 'sections', 'subjects'));
    }


    public function storeExam(ExamRequest $request)
    {
        $validatedData = $request->validated();
        $teacherId = Auth::id();

        $validatedData['teacher_id'] = array_fill(0, count($validatedData['name']), $teacherId);


        try {
            $this->storeExams($validatedData, Exam::class);
            toastr()->success('The exams have been added successfully.');
            return redirect()->route('teacher.exam');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function getQuestions()
    {
        try {
            $teacher = Auth::user();
            $teacherSections = DB::table('teacher_section')->where('teacher_id', $teacher->id)->get();
            $sectionIds = $teacherSections->pluck('section_id');
            $exams = Exam::whereIn('section_id', $sectionIds)->get();
            $questions = collect();
            foreach ($exams as $exam) {
                $examQuestions = $exam->questions;
                if ($examQuestions) {
                    $questions = $questions->merge($examQuestions);
                }
            }

            return view('teacherData.myQuestions', compact('questions', 'exams'));
        } catch (\Exception $e) {
            toastr()->error('An error occurred while fetching the questions: ' . $e->getMessage());
            return redirect()->route('teacher.myQuestions');
        }
    }
    public function getSessions()
    {
        try {
            $teacher = Auth::user();

            $teacherSections = DB::table('teacher_section')->where('teacher_id', $teacher->id)->get();
            $sectionIds = $teacherSections->pluck('section_id');

            $sections = Section::whereIn('id', $sectionIds)->get();
            $academicLevels = AcademicLevel::whereIn('id', $sections->pluck('academic_level_id'))->get();
            $classrooms = Classroom::whereIn('id', $sections->pluck('classroom_id'))->get();

            $online_sessions = OnlineSession::where('created_by', $teacher->email)->get();

            return view('teacherData.mySessions', compact('online_sessions', 'academicLevels', 'classrooms', 'sections'));
        } catch (\Exception $e) {
            toastr()->error('An error occurred while fetching the sessions: ' . $e->getMessage());
            return redirect()->route('teacher.exam');
        }
    }

    public function storeSession(Request $request)
    {
        try {
            $meeting = ZoomHelper::createMeeting($request);

            $academicLevelId = $request->input('academic_level_id')[0] ?? null;
            $classroomId = $request->input('classroom_id')[0] ?? null;
            $sectionId = $request->input('section_id')[0] ?? null;
            $topic = $request->input('topic')[0] ?? null;
            $startTime = $request->input('start_time')[0] ?? null;

            if (!$academicLevelId || !$classroomId || !$sectionId || !$topic || !$startTime) {
                throw new \Exception("Missing required fields in the request.");
            }


            $meetingId = $meeting['meeting_id'];
            $startUrl = $meeting['start_url'];
            $joinUrl = $meeting['join_url'];
            $meetingDetails = $meeting['meeting'];


            OnlineSession::create([
                'is_integrated' => true,
                'academic_level_id' => $academicLevelId,
                'classroom_id' => $classroomId,
                'section_id' => $sectionId,
                'created_by' => auth()->user()->email,
                'meeting_id' => $meetingId,
                'topic' => $topic,
                'start_at' => $startTime,
                'duration' => $meetingDetails['duration'] ?? $request->input('duration')[0] ?? null,
                'password' => $meetingDetails['password'] ?? 'wael',
                'start_url' => $startUrl,
                'join_url' => $joinUrl,
            ]);


            toastr()->success('The online session was successfully created.');
            return redirect()->route('teacher.sessions');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function storeIndirectSession(Request $request)
    {
        try {
            OnlineSession::create([
                'is_integrated' => 0,
                'academic_level_id' => $request->input('academic_level_id')[0],
                'classroom_id' => $request->input('classroom_id')[0],
                'section_id' => $request->input('section_id')[0],
                'created_by' => auth()->user()->email,
                'meeting_id' => $request->input('meeting_id')[0],
                'topic' => $request->input('topic')[0],
                'start_at' => $request->input('start_time')[0],
                'duration' => $request->input('duration')[0],
                'password' => $request->input('password')[0],
                'start_url' => $request->input('start_url')[0],
                'join_url' => $request->input('join_url')[0],
            ]);

            toastr()->success('The online session was successfully created.');
            return redirect()->route('teacher.sessions');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function  destroySession($id)
    {
        try {
            $session = OnlineSession::find($id);

            if (!$session) {
                return redirect()->back()->with(['error' => 'Session not found.']);
            }

            if ($session->is_integrated && $session->meeting_id) {
                $accessToken = ZoomHelper::getZoomAccessToken();

                if (!$accessToken) {
                    return redirect()->back()->with(['error' => 'Unable to retrieve Zoom access token.']);
                }

                $zoomResponse = Http::withToken($accessToken)
                    ->delete("https://api.zoom.us/v2/meetings/{$session->meeting_id}");

                if ($zoomResponse->failed()) {
                    return redirect()->back()->with(['error' => 'Failed to delete Zoom meeting: ' . $zoomResponse->body()]);
                }
            }

            OnlineSession::destroy($id);

            toastr()->success('The online session was successfully deleted.');
            return redirect()->route('teacher.sessions');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    public function getProfile()
    {
        try {
            $teacher = Auth::user();

            return view('teacherData.myProfile', compact('teacher'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    public function updateProfile()
    {
        try {
            toastr()->success('The profile was updated successfully.');
            return redirect()->route('teacher.sessions');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($examId)
    {
        try {
            $exam = Exam::findOrFail($examId);
            $exam->delete();
            toastr()->success('The exam has been deleted successfully.');
        } catch (\Exception $e) {
            toastr()->error('An error occurred while deleting the exam.');
        }

        return redirect()->route('teacher.exam');
    }
    public function studentsCompleted(Exam $exam)
    {
        // Get all students who completed the exam
        $students = Student::whereIn('id', function ($query) use ($exam) {
            $query->select('student_id')
                ->from('student_question_marks')
                ->where('exam_id', $exam->id);
        })->get();

        $students = $students->map(function ($student) use ($exam) {

            $cheatingDetected = \DB::table('student_question_marks')
                ->where('exam_id', $exam->id)
                ->where('student_id', $student->id)
                ->where('cheating_status', 'suspected')
                ->exists();


            $student->cheating_status = $cheatingDetected;
            return $student;
        });

        return view('teacherData.studentsCompleted', [
            'exam' => $exam,
            'students' => $students,
        ]);
    }

    public function remakeExamForStudent(Exam $exam, $studentId)
    {
        \DB::table('student_question_marks')
            ->where('exam_id', $exam->id)
            ->where('student_id', $studentId)
            ->delete();

        return redirect()->back()->with('success', 'Exam reset for the student successfully!');
    }
}
