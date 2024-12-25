<?php

namespace App\Http\Requests\Executive;

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
            'first_name' => 'required',
            'last_name' => 'required',
            'party' => 'required',
            'state' => 'required',
            'city' => 'required',
            'home_city' => 'required',
            'birthday' => 'required',
            'religion' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name' => 'First Name field cannot be empty.',
            'last_name' => 'Last Name field cannot be empty.',
            'party' => 'Party field cannot be empty.',
            'state' => 'State field cannot be empty.',
            'city' => 'City field cannot be empty.',
            'home_city' => 'Home City field cannot be empty.',
            'birthday' => 'Birthday field cannot be empty.',
            'religion' => 'Religion field cannot be empty.',
        ];
    }
}
