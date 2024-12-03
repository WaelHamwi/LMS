<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeachers extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $isUpdate = $this->route('teacher') ? true : false;
        return [
            'first_name.*' => 'required|string|max:255', 
            'last_name.*' => 'required|string|max:255',
            'email.*' => 'required|email|unique:users,email|max:255',
            'password.*' => $isUpdate ? 'nullable|min:6' : 'required|min:6', 
            'address.*' => $isUpdate ? 'nullable|string|max:255' : 'required|string|max:255', 
            'gender_id.*' => 'required|exists:genders,id',
            'specialization_id.*' => 'required|exists:specializations,id',
            'join_date.*' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'address.required' => 'The address field is required.',
            'gender_id.required' => 'The gender field is required.',
            'gender_id.exists' => 'The selected gender is invalid.',
            'specialization_id.required' => 'The specialization field is required.',
            'specialization_id.exists' => 'The selected specialization is invalid.',
            'join_date.required' => 'The join date field is required.',
            'join_date.date' => 'The join date must be a valid date.',
        ];
    }
}
