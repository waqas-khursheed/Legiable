<?php

namespace App\Http\Requests\Spending;

use Illuminate\Foundation\Http\FormRequest;

class SpendingData extends FormRequest
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
            'fiscal_year' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fiscal_year' => 'Fiscal year field cannot be empty.',
        ];
    }
}
