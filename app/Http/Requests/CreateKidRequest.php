<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateKidRequest extends FormRequest
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
            'achternaam' => 'min:2',
            'voornaam' => 'required|min:2',
            'geboortedatum' => 'required|before:'. date("Y-m-d"),
            'geslacht' => 'required',
            'family_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    public function messages()
    {
        return [
            'achternaam.min'  => 'De achternaam moet minimaal 2 karakters hebben.',
            'voornaam.required'  => 'U moet een achternaam opgeven.',
            'voornaam.min'  => 'De achternaam moet minimaal 2 karakters hebben.',
            'geboortedatum.required'  => 'U moet een geboortedatum opgeven.',
            'geboortedatum.before'  => 'De geboortedatum ligt in de toekomst.',
            'geslacht.required'  => 'U moet een geslacht opgeven.',
        ];
    }

}
