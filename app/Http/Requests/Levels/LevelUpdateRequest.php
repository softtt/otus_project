<?php


namespace App\Http\Requests\Levels;


class LevelUpdateRequest extends \Illuminate\Foundation\Http\FormRequest
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
            'name' => ['string', 'max:255'],
            'description' => ['string', 'max:255'],
        ];
    }
}
