<?php

namespace App\Http\Requests;

use App\Services\Requests\NasdaqApiRequest;
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
    public function rules(NasdaqApiRequest $nasdaqApiRequest)
    {
        $validSymbols = $nasdaqApiRequest->get()->symbolsArray()->implode(',');
        return [
            'company_symbol'=>'required|in:'.$validSymbols,
            'email'=> 'required|email',
            'start_date'=> 'bail|required|date|date_format:Y-m-d|before_or_equal:today|before_or_equal:end_date',
            'end_date' => 'bail|required|date|date_format:Y-m-d|after_or_equal:start_date|before_or_equal:today',
        ];
    }
}
