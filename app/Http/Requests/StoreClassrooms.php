<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassrooms extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $classroomId = $this->route('classroom') ? $this->route('classroom')->id : null;

        return [
            'academic_level_id' => 'required|exists:academic_levels,id',
            'academic_level_id.*' => 'exists:academic_levels,id',
            'name' => 'required|max:255|unique:classrooms,name,' . $classroomId,
            'name.*' => 'max:255|unique:classrooms,name,' . $classroomId,
            'description' => 'nullable|string',
        ];
    }
    

    public function messages()
    {
        return [
            'academic_level_id.required' => 'The academic level field is required.',
            'academic_level_id.exists' => 'The selected academic level does not exist.',
            'name.required' => 'The name field is required.',
            'name.unique' => 'This classroom name already exists.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'description.string' => 'The description must be a string.',
        ];
    }
}
