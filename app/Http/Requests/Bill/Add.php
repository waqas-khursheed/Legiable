<?php

namespace App\Http\Requests\Bill;

use Illuminate\Foundation\Http\FormRequest;

class Add extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'congress' => 'required',
            'bill_type' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'congress' => 'Congress field cannot be empty.',
            'bill_type' => 'Bill Type field cannot be empty.',
            'from_date' => 'From Date cannot be empty.',
            'to_date' => 'To Date cannot be empty.',
        ];
    }
}
