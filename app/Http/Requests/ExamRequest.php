<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name.0' => 'required|string|max:255',
            'subject_id.0' => 'required|exists:subjects,id',
            'academic_level_id.0' => 'required|exists:academic_levels,id',
            'classroom_id.0' => 'required|exists:classrooms,id',
            'section_id.0' => 'required|exists:sections,id',
            'name.*' => 'required|string|max:255',
            'subject_id.*' => 'required|exists:subjects,id',
            'academic_level_id.*' => 'required|exists:academic_levels,id',
            'classroom_id.*' => 'required|exists:classrooms,id',
            'section_id.*' => 'required|exists:sections,id',
        ];
    }

    public function messages()
    {
        return [
            'name.0.required' => 'The name field is required.',
            'name.*.required' => 'Each exam must have a name.',
            'name.*.string' => 'The name must be a string.',
            'name.*.max' => 'The name must not exceed 255 characters.',
            'subject_id.0.required' => 'The subject field is required.',
            'subject_id.*.required' => 'Each exam must have a subject.',
            'subject_id.*.exists' => 'The selected subject is invalid.',
            'academic_level_id.0.required' => 'The academic level field is required.',
            'academic_level_id.*.required' => 'Each exam must have an academic level.',
            'academic_level_id.*.exists' => 'The selected academic level is invalid.',
            'classroom_id.0.required' => 'The classroom field is required.',
            'classroom_id.*.required' => 'Each exam must have a classroom.',
            'classroom_id.*.exists' => 'The selected classroom is invalid.',
            'section_id.0.required' => 'The section field is required.',
            'section_id.*.required' => 'Each exam must have a section.',
            'section_id.*.exists' => 'The selected section is invalid.',
        ];
    }
}

