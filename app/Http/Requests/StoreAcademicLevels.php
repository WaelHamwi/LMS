<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAcademicLevels extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $academicLevelId = $this->route('academic_level') ? $this->route('academic_level')->id : null;

        return [
            'name' => 'required|max:255|unique:academic_levels,name,' . $academicLevelId,
            'description' => 'nullable',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.unique' => 'This academic level name already exists.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'description.string' => 'The description must be a string.',
        ];
    }
}
