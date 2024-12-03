<?php

namespace App\Repositories\Academic;

use App\Models\AcademicLevel;
use App\Http\Requests\StoreAcademicLevels;


class AcademicLevelRepository implements AcademicLevelRepositoryInterface
{
    public function index()
    {
        $academicLevels = AcademicLevel::all();
        return view('AcademicLevels.index', compact('academicLevels'));
    }

    public function create(StoreAcademicLevels $request)
    {
        return view('academic_levels.create');
    }

    public function store(StoreAcademicLevels $request)
    {
        try {
            $validated = $request->validated();
            foreach ($validated['name'] as $index => $name) {
                $academicLevel = new AcademicLevel();
                $academicLevel->name = $name;
                $academicLevel->description = $validated['description'][$index] ?? null;
                $academicLevel->save();
            }
    
            toastr()->success(__('The academic levels have been added'));
            return redirect()->route('academic_levels.index');
        } catch (\Exception $e) {
            toastr()->error(__('messages.error') . $e->getMessage());
            return redirect()->back();
        }
    }
    

    public function show(AcademicLevel $academicLevel)
    {
        return view('academic_levels.show', compact('academicLevel'));
    }

    public function edit(AcademicLevel $academicLevel)
    {
        return view('academic_levels.edit', compact('academicLevel'));
    }

    public function update(StoreAcademicLevels $request, AcademicLevel $academicLevel)
    {
        try {
            $validatedData = $request->validated();
            $isUpdated = false;
            foreach ($validatedData as $key => $value) {
                if ($academicLevel->{$key} !== $value) {
                    $isUpdated = true;
                    break;
                }
            }
            if ($isUpdated) {
                $academicLevel->update([
                    'name' => $validatedData['name'][0],
                    'description' => $validatedData['description'][0] ?? null,
                ]);
                return redirect()->route('academic_levels.index')->with('success', 'Academic Level updated successfully.');
            } else {
                return redirect()->route('academic_levels.index')->with('info', 'No fields were updated.');
            }
        } catch (\Exception $e) {

            toastr()->error(__('messages.error' . $e->getMessage()));
        }
    }



    public function destroy(AcademicLevel $academicLevel)
    {
        try {
            if ($academicLevel->classrooms()->count() > 0) {
                return redirect()->route('academic_levels.index')->with('error', 'Cannot delete this Academic Level because it has associated classrooms.');
            }
            $academicLevel->delete();
            return redirect()->route('academic_levels.index')->with('success', 'Academic Level deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('academic_levels.index')->with('error', 'An error occurred while trying to delete the Academic Level: ' . $e->getMessage());
        }
    }
    public function bulkDelete(array $ids)
    {
        try {
            $academicLevelsWithClassrooms = AcademicLevel::whereIn('id', $ids)
                ->has('classrooms')
                ->pluck('name');

            $academicLevelsWithoutClassrooms = AcademicLevel::whereIn('id', $ids)
                ->doesntHave('classrooms')
                ->pluck('id');

            if ($academicLevelsWithoutClassrooms->isNotEmpty()) {
                AcademicLevel::whereIn('id', $academicLevelsWithoutClassrooms)->delete();
            }

            if ($academicLevelsWithClassrooms->isNotEmpty()) {
                return redirect()->route('academic_levels.index')->with('info', 'The following Academic Levels cannot be deleted because they have classrooms: ' . $academicLevelsWithClassrooms->join(', '));
            }

            return redirect()->route('academic_levels.index')->with('success', 'Selected Academic Levels have been deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('academic_levels.index')->with('error', 'An error occurred while trying to delete the Academic Levels: ' . $e->getMessage());
        }
    }
}
