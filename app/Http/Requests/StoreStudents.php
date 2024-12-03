<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudents extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $studentId = $this->route('student') ? $this->route('student')->id : null;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . ($studentId ? $studentId : 'NULL'),
            'password' => $studentId ? 'nullable|string|min:8' : 'required|string|min:8',
            'gender' => 'required|in:male,female,other',
            'blood' => 'nullable|string',
            'nationality' => 'nullable|string',
            'date_of_birth' => 'required|date',
            'academic_level_id' => 'required|exists:academic_levels,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'parent_id' => 'nullable|exists:student_parents,id',
            'academic_year' => 'required|date_format:Y',
            '_method' => 'sometimes|string',
            'student_photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' 
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The student name is required.',
            'name.string' => 'The student name must be a string.',
            'name.max' => 'The student name may not be greater than 255 characters.',
            'email.required' => 'The student email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already associated with another student.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'gender.required' => 'The gender field is required.',
            'gender.in' => 'Gender must be one of the following: male, female, or other.',
            'date_of_birth.required' => 'The date of birth is required.',
            'date_of_birth.date' => 'Please provide a valid date of birth.',
            'academic_level_id.required' => 'The academic level is required.',
            'academic_level_id.exists' => 'The selected academic level does not exist.',
            'class_id.required' => 'The class is required.',
            'class_id.exists' => 'The selected class does not exist.',
            'section_id.required' => 'The section is required.',
            'section_id.exists' => 'The selected section does not exist.',
            'parent_id.exists' => 'The selected parent does not exist.',
            'academic_year.required' => 'The academic year is required.',
            'academic_year.date_format' => 'The academic year must be a valid year format (e.g., 2024).',
        ];
    }
}
