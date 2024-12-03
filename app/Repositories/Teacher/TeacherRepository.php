<?php

namespace App\Repositories\Teacher;

use App\Http\Requests\StoreTeachers;
use App\Models\Teacher;
use App\Models\Gender;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherRepository implements TeacherRepositoryInterface
{
    public function index(Request $request)
    {
        $teachers = Teacher::with(['gender', 'specialization'])->get();
        $genders = Gender::all();
        $specializations = Specialization::all();

        return view('teachers.index', compact('teachers', 'genders', 'specializations'));
    }


    public function create(StoreTeachers $request)
    {
        return $request;
    }

    public function store(StoreTeachers $request)
    {
        try {
            $validatedData = $request->validated();

            foreach ($validatedData['first_name'] as $index => $firstName) {
                Teacher::create([
                    'first_name' => $firstName,
                    'last_name' => $validatedData['last_name'][$index],
                    'email' => $validatedData['email'][$index],
                    'password' => isset($validatedData['password'][$index]) ? Hash::make(trim($validatedData['password'][$index])) : null,
                    'address' => $validatedData['address'][$index],
                    'gender_id' => $validatedData['gender_id'][$index],
                    'specialization_id' => $validatedData['specialization_id'][$index],
                    'join_date' => $validatedData['join_date'][$index],
                ]);
            }

            toastr()->success(__('The teacher have been added successfully'));
            return redirect()->route('teachers.index');
        } catch (\Exception $e) {
            toastr()->error(__('Error: ' . $e->getMessage()));
            return redirect()->back();
        }
    }




    public function show(Teacher $teacher)
    {
        return $teacher;
    }

    public function edit(Teacher $teacher)
    {
        return $teacher;
    }

    public function update(StoreTeachers $request, Teacher $teacher)
    {

        try {
            $validatedData = $request->validated();
            foreach ($validatedData['first_name'] as $index => $firstName) {
                $currentTeacher = Teacher::findOrFail($teacher->id);
                $updateData = [
                    'first_name' => $firstName,
                    'last_name' => $validatedData['last_name'][$index],
                    'email' => $validatedData['email'][$index],
                    'address' => $validatedData['address'][$index],
                    'gender_id' => $validatedData['gender_id'][$index],
                    'specialization_id' => $validatedData['specialization_id'][$index],
                    'join_date' => $validatedData['join_date'][$index],
                ];
                if (!empty($validatedData['password'][$index])) {
                    $updateData['password'] = Hash::make($validatedData['password'][$index]);
                }
                $currentTeacher->update($updateData);
            }

            toastr()->success(__('The teacher has been updated successfully'));
            return redirect()->route('teachers.index');
        } catch (\Exception $e) {
            toastr()->error(__('Error: ' . $e->getMessage()));
            return redirect()->back();
        }
    }



    public function destroy(Teacher $teacher)
    {
        try {
            if ($teacher->delete()) {
                toastr()->success(__('The teacher has been deleted successfully'));
                return redirect()->route('teachers.index');
            }
        } catch (\Exception $e) {
            toastr()->error(__('Error: ' . $e->getMessage()));
            return redirect()->back();
        }
    }

    public function bulkDelete(array $ids)
    {
        return Teacher::destroy($ids);
    }
}
