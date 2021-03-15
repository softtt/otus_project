<?php


namespace App\Http\Requests\Lessons;


class LessonsStoreRequest extends \Illuminate\Foundation\Http\FormRequest
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
            'name' => ['string', 'required', 'max:255'],
            'description' => ['string', 'required', 'max:255'],
            'start_date' => ['date_format:Y-m-d'],
        ];
    }
}
