<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
            'firstname' => ['string', 'max:255'],
            'lastname' => ['string', 'max:255'],
            'email' => ['email'],
            'study_begins_date' => ['date_format:Y-m-d'],
            'birthday' => ['date_format:Y-m-d'],
        ];
    }
}
