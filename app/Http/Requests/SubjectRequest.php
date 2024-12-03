<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name.*' => 'required|string|max:255',
            'academic_level_id.*' => 'required|exists:academic_levels,id',
            'classroom_id.*' => 'required|exists:classrooms,id',
            'teacher_id.*' => 'required|exists:teachers,id',
            'name.0' => 'required|string|max:255',
            'academic_level_id.0' => 'required|exists:academic_levels,id',
            'classroom_id.0' => 'required|exists:classrooms,id',
            'teacher_id.0' => 'required|exists:teachers,id',
        ];
    }

    public function messages()
    {
        return [
            'name.*.required' => 'Each subject must have a name.',
            'name.*.string' => 'The name must be a string.',
            'name.*.max' => 'The name must not exceed 255 characters.',
            'academic_level_id.*.required' => 'Each subject must have an academic level.',
            'academic_level_id.*.exists' => 'The selected academic level is invalid.',
            'classroom_id.*.required' => 'Each subject must have a classroom.',
            'classroom_id.*.exists' => 'The selected classroom is invalid.',
            'teacher_id.*.required' => 'Each subject must have a teacher.',
            'teacher_id.*.exists' => 'The selected teacher is invalid.',
        ];
    }
}
