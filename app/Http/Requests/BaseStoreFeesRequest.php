<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseStoreFeesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $count = count($this->input('title'));

        $rules = [];
        
        for ($i = 0; $i < $count; $i++) {
            $rules["title.$i"] = 'required|string|max:255';
            $rules["amount.$i"] = 'required|numeric|min:0';
            $rules["academic_level_id.$i"] = 'required|integer|exists:academic_levels,id';
            $rules["classroom_id.$i"] = 'required|integer|exists:classrooms,id';
            $rules["section_id.$i"] = 'required|integer|exists:sections,id';
            $rules["year.$i"] = 'required|integer|digits:4|min:' . date('Y') . '|max:' . (date('Y') + 1);
            $rules["description.$i"] = 'nullable|string|max:500';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.*.required' => 'The title is required.',
            'amount.*.required' => 'The amount is required.',
            'amount.*.numeric' => 'The amount must be a valid number.',
            'academic_level_id.*.required' => 'The academic level is required.',
            'academic_level_id.*.exists' => 'The selected academic level does not exist.',
            'classroom_id.*.required' => 'The classroom is required.',
            'classroom_id.*.exists' => 'The selected classroom does not exist.',
            'section_id.*.required' => 'The section is required.',
            'section_id.*.exists' => 'The selected section does not exist.',
            'year.*.required' => 'The year is required.',
            'year.*.digits' => 'The year must be a 4-digit number.',
            'year.*.min' => 'The year must be the current year or later.',
            'year.*.max' => 'The year cannot exceed next year.',
            'description.*.nullable' => 'The description must be a string.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'title' => $this->input('title'),
            'amount' => array_map(fn($amount) => is_numeric($amount) ? (float) $amount : $amount, $this->input('amount')),
            'academic_level_id' => $this->input('academic_level_id'),
            'classroom_id' => $this->input('classroom_id'),
            'section_id' => $this->input('section_id'),
            'year' => $this->input('year'),
            'description' => $this->input('description'),
        ]);
    }
}
