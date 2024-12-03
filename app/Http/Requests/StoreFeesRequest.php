<?php

namespace App\Http\Requests;

class StoreFeesRequest extends BaseStoreFeesRequest
{
    public function rules()
    {
        $rules = parent::rules();

        $count = count($this->input('title'));

        for ($i = 0; $i < $count; $i++) {
            $rules["fee_type.$i"] = 'required|string|max:100';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = parent::messages();

        $messages['fee_type.*.required'] = 'The fee type is required.';

        return $messages;
    }

    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $this->merge([
            'fee_type' => $this->input('fee_type'),
        ]);
    }
}
