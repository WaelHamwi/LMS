<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceiptProcessFeeStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $data = $this->all();
        $isBatch = is_array(data_get($data, 'student_id'));

        return [
            'student_id' => $isBatch ? 'required|array' : 'required|exists:students,id',
            'student_id.*' => $isBatch ? 'required|exists:students,id' : '',

            'credit' => $isBatch ? 'required|array' : 'required|numeric|min:0',
            'credit.*' => $isBatch ? 'required|numeric|min:0' : '',

            'description' => $isBatch ? 'nullable|array' : 'nullable|string|max:255',
            'description.*' => $isBatch ? 'nullable|string|max:255' : '',


        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'The student selection is required.',
            'student_id.exists' => 'The selected student does not exist.',
            'student_id.*.required' => 'Each student selection is required.',
            'student_id.*.exists' => 'Each selected student must exist.',

            'credit.required' => 'The credit is required.',
            'credit.numeric' => 'The credit must be numeric.',
            'credit.min' => 'The credit cannot be negative.',
            'credit.*.required' => 'Each credit amount is required.',
            'credit.*.numeric' => 'Each credit amount must be numeric.',
            'credit.*.min' => 'Each credit cannot be negative.',

            'description.string' => 'The description must be a string.',
            'description.max' => 'The description cannot exceed 255 characters.',
            'description.*.string' => 'Each description must be a string.',
            'description.*.max' => 'Each description cannot exceed 255 characters.',



        ];
    }
}
