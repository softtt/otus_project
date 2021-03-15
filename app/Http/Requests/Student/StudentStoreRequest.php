<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => ['string', 'required', 'max:255'],
            'lastname' => ['string', 'required', 'max:255'],
            'email' => ['email', 'required', 'unique:students,email'],
            'study_begins_date' => ['date_format:Y-m-d'],
            'birthday' => ['date_format:Y-m-d'],
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'firstname.required' => 'Firstname is required!',
            'lastname.required' => 'LastName is required!',
            'email.required' => 'Email is required!'
        ];
    }
}
