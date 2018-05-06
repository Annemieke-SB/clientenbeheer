<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateBlacklistRequest extends FormRequest
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
            'reden' => 'required|min:10',
            'email' => 'required|email|unique',
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    public function messages()
    {
        return [
            'email.required'  => 'U moet een emailadres opgeven.',
            'email.email'  => 'U heeft geen geldig emailadres opgegeven.',
            'email.unique'  => 'Het emailadres is al bekend bij ons.',
            'reden.required'  => 'U heeft geen motivatie opgegeven.',
            'reden.min'  => 'De motivatie moet minimaal uit 10 karakters bestaan.',
        ];
    }

}
