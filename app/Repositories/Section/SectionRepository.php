<?php

namespace App\Repositories\Section;

use App\Models\Section;
use App\Models\Classroom;
use App\Models\AcademicLevel;
use App\Http\Requests\StoreSections;
use App\Models\Teacher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
class SectionRepository implements SectionRepositoryInterface
{
    public function index(Request $request)
    {
        $classroomId = $request->input('id');

        $isTeacher = Auth::guard('teacher')->check();
        $teacherId = $isTeacher ? Auth::guard('teacher')->id() : null;

        $sectionsQuery = Section::with(['academicLevel', 'classroom', 'teachers']);

        if ($isTeacher) {
            $sectionsQuery->whereHas('teachers', function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            });
        }

        if ($classroomId) {
            $sectionsQuery->where('classroom_id', $classroomId);
        }

        $sections = $sectionsQuery->get();

        $academicLevels = Cache::remember('academic_levels', 60 * 60, function () {
            return AcademicLevel::all();
        });

        $teachers = Cache::remember('teachers', 60 * 60, function () {
            return Teacher::all();
        });

        $classrooms = Cache::remember('classrooms', 60 * 60, function () {
            return Classroom::all();
        });

        $isEditMode = $request->has('edit') && $request->input('edit') == true;

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'sections' => $sections,
                'academicLevels' => $academicLevels,
                'teachers' => $teachers,
            ]);
        }

        return view('Sections.index', compact('sections', 'academicLevels', 'classrooms', 'teachers'));
    }







    public function create(StoreSections $request)
    {
        return view('sections.create');
    }

    public function store(StoreSections $request)
    {
        //  dd($request);
        Log::info('Raw Request Data:', $request->all());

        try {
            $validatedData = $request->validated();

            foreach ($validatedData['name'] as $index => $name) {
                $section = Section::create([
                    'name' => $name,
                    'academic_level_id' => $validatedData['academic_level_id'][$index],
                    'classroom_id' => $validatedData['classroom_id'][$index],
                    'status' => isset($validatedData['status'][$index]) && $validatedData['status'][$index] == 1 ? 1 : 0,
                ]);

                if (isset($validatedData['teacher_ids']) && !empty($validatedData['teacher_ids'][$index])) {
                    $teacherIds = $validatedData['teacher_ids'];
                    foreach ($teacherIds as $key => $teacherId) {
                        $section->teachers()->attach($teacherId);
                    }
                }
            }

            toastr()->success(__('The sections have been added'));
            return redirect()->route('sections.index');
        } catch (Exception $e) {
            toastr()->error(__('messages.error' . $e->getMessage()));
            return redirect()->back();
        }
    }



    public function show(Section $section)
    {
        return view('sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        return view('sections.edit', compact('section'));
    }

    public function update(StoreSections $request, Section $section)
    {
        try {
            $validatedData = $request->validated();

            $section->update([
                'name' => $validatedData['name'][0],
                'academic_level_id' => $validatedData['academic_level_id'][0],
                'classroom_id' => $validatedData['classroom_id'][0],
                'status' => isset($validatedData['status'][0]) && $validatedData['status'][0] == 1 ? 1 : 0,
            ]);
            if (isset($validatedData['teacher_ids']) && !empty($validatedData['teacher_ids'][0])) {
                $section->teachers()->detach();
                $teacherIds = $validatedData['teacher_ids'];
                foreach ($teacherIds as $key => $teacherId) {
                    $section->teachers()->attach($teacherId);
                }
            } else {
                $section->teachers()->detach();
            }

            toastr()->success(__('Section updated successfully.'));
            return redirect()->route('sections.index');
        } catch (Exception $e) {
            toastr()->error(__('An error occurred: ') . $e->getMessage());
            return redirect()->back();
        }
    }





    public function destroy(Section $section)
    {
        try {
            $section->delete();
            return redirect()->route('sections.index')->with('success', 'Section has been deleted successfully.');
        } catch (\Exception $e) {
            toastr()->error(__('Failed to delete the section: ') . $e->getMessage());
            return redirect()->route('sections.index');
        }
    }

    public function bulkDelete(array $ids)
    {
        try {
            if (empty($ids)) {
                return redirect()->route('sections.index')->with('info', 'No Sections were selected.');
            }

            Section::whereIn('id', $ids)->delete();

            return redirect()->route('sections.index')->with('success', 'Selected sections have been deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('sections.index')->with('error', 'An error occurred while trying to delete the sections: ' . $e->getMessage());
        }
    }
}
