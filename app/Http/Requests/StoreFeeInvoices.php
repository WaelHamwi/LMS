<?php

namespace App\Http\Requests;

class StoreFeeInvoices extends BaseStoreFeesRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $count = count($this->input('title'));

        for ($i = 0; $i < $count; $i++) {
            $rules["student_id.$i"] = 'required|integer|exists:students,id';
            $rules["fee_id.$i"] = 'required|integer|exists:fees,id';
            $rules["fee_type.$i"] = 'required|string|max:100';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = parent::messages();

        $messages['student_id.*.required'] = 'The student ID is required.';
        $messages['student_id.*.exists'] = 'The selected student does not exist.';
        $messages['fee_id.*.required'] = 'The fee ID is required.';
        $messages['fee_id.*.exists'] = 'The selected fee does not exist.';
        $messages['fee_type.*.required'] = 'The fee type is required.';

        return $messages;
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $this->merge([
            'student_id' => $this->input('student_id'),
            'fee_id' => $this->input('fee_id'),
            'fee_type' => $this->input('fee_type'),
        ]);
    }
}
