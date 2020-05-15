<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DemoFormRequest extends FormRequest
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
            'company_symbol'=>'required',
            'email'=> 'required|email',
            'start_date'=> 'bail|date|date_format:Y-m-d|before:today',
            'end_date' => 'bail|date|date_format:Y-m-d|after_or_equal:start_date|before:today',
        ];
    }
}
