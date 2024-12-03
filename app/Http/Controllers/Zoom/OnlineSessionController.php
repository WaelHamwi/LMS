<?php

namespace App\Http\Controllers\Zoom;

use App\Http\Controllers\Controller;
use App\Models\AcademicLevel;
use App\Models\Classroom;
use App\Models\Section;
use App\Models\OnlineSession;
use Illuminate\Http\Request;
use App\Helpers\Zoom\ZoomHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OnlineSessionController extends Controller
{
    public function index()
    {
        $academicLevels = AcademicLevel::all();
        $classrooms = Classroom::all();
        $sections = Section::all();
        $online_sessions = OnlineSession::where('created_by', auth()->user()->email)->get();
        return view('Zoom.index', compact('online_sessions', 'academicLevels', 'classrooms', 'sections'));
    }

    public function store(Request $request)
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
            return redirect()->route('online_sessions.index');
        } catch (\Exception $e) {
            Log::error('Error creating Zoom meeting: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function storeIndirect(Request $request)
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
            return redirect()->route('online_sessions.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
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
            return redirect()->route('online_sessions.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
