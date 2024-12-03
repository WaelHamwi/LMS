<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSections extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $sectionId = $this->route('section') ? $this->route('section')->id : null;

        return [
            'name.*' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($sectionId) {
                    $academicLevelId = $this->input('academic_level_id.0');
                    $classroomId = $this->input('classroom_id.0');

                    if ($academicLevelId && $classroomId) {
                        $exists = \App\Models\Section::where('name', $value)
                            ->where('academic_level_id', $academicLevelId)
                            ->where('classroom_id', $classroomId)
                            ->when($sectionId, function ($query) use ($sectionId) {
                                $query->where('id', '!=', $sectionId);
                            })
                            ->exists();

                        if ($exists) {
                            $fail("The section name '$value' already exists for the selected academic level and classroom.");
                        }
                    }
                }
            ],
            'academic_level_id.*' => 'required|exists:academic_levels,id',
            'classroom_id.*' => 'required|exists:classrooms,id',
            'status.*' => 'required|boolean',
            'teacher_ids.*' => 'exists:teachers,id',
        ];
    }

    public function messages()
    {
        return [
            'name.*.required' => 'The section name is required.',
            'name.*.string' => 'The section name must be a string.',
            'name.*.max' => 'The section name may not be greater than 255 characters.',
            'academic_level_id.*.required' => 'The academic level is required.',
            'academic_level_id.*.exists' => 'The selected academic level does not exist.',
            'classroom_id.*.required' => 'The classroom is required.',
            'classroom_id.*.exists' => 'The selected classroom does not exist.',
            'status.*.required' => 'The status field is required.',
            'status.*.boolean' => 'The status field must be true or false.',
            'teacher_ids.*.exists' => 'One or more selected teachers do not exist.',
        ];
    }
}
