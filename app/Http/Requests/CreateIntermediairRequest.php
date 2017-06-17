<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateIntermediairRequest extends FormRequest
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
            'type' => 'required',
            'adres' => 'required',
            'huisnummer' => 'required',
            'huisnummertoevoeging',
            'postcode' => 'required|size:6|alpha_num',
            'woonplaats' => 'required'
        
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    public function messages()
    {
        return [
            'type.required'  => 'U moet een type instelling selecteren.',
            'huisnummer.required'  => 'U moet een huisnummer opgeven.',
            'postcode.required'  => 'U moet een geldige Nederlandse postcode opgeven (zoals 1234AB).',
            'adres.required'  => 'Adres kon niet worden opgehaald. Klopt de postcode of huisnummer wel?',
            'woonplaats.required'  => 'Plaats kon niet worden opgehaald. Klopt de postcode of huisnummer  wel?',
            'postcode.size'  => 'U moet een postcode opgeven (zoals 1234AB).',   
            'postcode.alpha_num'  => 'U moet een postcode opgeven (zoals 1234AB).'
        ];
    }

}
