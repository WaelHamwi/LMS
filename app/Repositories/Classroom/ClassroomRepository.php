<?php

namespace App\Repositories\Classroom;

use App\Models\Classroom;
use App\Models\AcademicLevel;
use App\Http\Requests\StoreClassrooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassroomRepository implements ClassroomRepositoryInterface
{
    public function index()
    {
        $classrooms = Classroom::with('academicLevel')->get();
        $academicLevels = AcademicLevel::all();
        return view('Classrooms.index', compact('classrooms', 'academicLevels'));
    }

    public function create(StoreClassrooms $request)
    {
        return view('classroom.create');
    }

    public function store(StoreClassrooms $request)
    {
        try {

            $validatedData = $request->validated();

            foreach ($validatedData['name'] as $index => $name) {
                Classroom::create([
                    'name' => $name,
                    'academic_level_id' => $validatedData['academic_level_id'][$index],
                ]);
            }

            toastr()->success(__('The classrooms have been added'));
            return redirect()->route('classrooms.index');
        } catch (\Exception $e) {
            toastr()->error(__('messages.error' . $e->getMessage()));
            return redirect()->back();
        }
    }


    public function show(Classroom $classroom)
    {
        return view('classrooms.show', compact('classrooms'));
    }

    public function edit(Classroom $classroom)
    {
        return view('classrooms.edit', compact('classroom'));
    }

    public function update(StoreClassrooms $request, Classroom $classroom)
    {
        try {
            $validatedData = $request->validated();
            $isUpdated = false;

            if (
                (int)$validatedData['academic_level_id'][0] !== (int)$classroom->academic_level_id ||
                $validatedData['name'][0] !== $classroom->name
            ) {
                $classroom->name = $validatedData['name'][0];
                $classroom->academic_level_id = (int)$validatedData['academic_level_id'][0];
                $isUpdated = $classroom->save();
            }

            if ($isUpdated) {
                return redirect()->route('classrooms.index')->with('success', 'Classroom Level updated successfully.');
            } else {
                return redirect()->route('classrooms.index')->with('info', 'No fields were updated.');
            }
        } catch (\Exception $e) {
            toastr()->error(__('messages.error') . $e->getMessage());
            return redirect()->back();
        }
    }


    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('classrooms.index')->with('success', 'classroom Level deleted successfully.');
    }
    public function bulkDelete(array $ids)
    {
        try {
            if (empty($ids)) {
                return redirect()->route('classrooms.index')->with('info', 'No Classrooms were selected.');
            }

            Classroom::whereIn('id', $ids)->delete();

            return redirect()->route('classrooms.index')->with('success', 'Selected classrooms have been deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('classrooms.index')->with('error', 'An error occurred while trying to delete the classrooms: ' . $e->getMessage());
        }
    }

    public function getClassroomsByAcademicLevel(Request $request)
    {
        try {
            $academicLevelId = $request->query('academic_level_id');
            $cacheKey = $academicLevelId ? "classrooms_level_{$academicLevelId}" : "classrooms_all";

            $isTeacher = Auth::guard('teacher')->check();
            $teacherId = $isTeacher ? Auth::guard('teacher')->id() : null;

            $classrooms = Cache::remember($cacheKey . ($teacherId ? "_teacher_{$teacherId}" : ""), 60 * 60, function () use ($academicLevelId, $teacherId, $isTeacher) {
                if ($isTeacher) {
                    $classroomIds = DB::table('teacher_section')
                        ->where('teacher_id', $teacherId)
                        ->join('sections', 'teacher_section.section_id', '=', 'sections.id')
                        ->pluck('sections.classroom_id')
                        ->unique();

                    return Classroom::whereIn('id', $classroomIds)
                        ->when($academicLevelId, function ($query) use ($academicLevelId) {
                            $query->where('academic_level_id', $academicLevelId);
                        })
                        ->get(['id', 'name']);
                } else {
                    return Classroom::when($academicLevelId, function ($query) use ($academicLevelId) {
                        $query->where('academic_level_id', $academicLevelId);
                    })
                        ->get(['id', 'name']);
                }
            });

            $classrooms = $classrooms->map(function ($classroom) {
                return [
                    'id' => $classroom->id,
                    'name' => $classroom->name,
                ];
            });

            return response()->json($classrooms);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve classrooms'], 500);
        }
    }
}
