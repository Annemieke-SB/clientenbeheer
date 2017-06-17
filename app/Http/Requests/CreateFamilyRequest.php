<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateFamilyRequest extends FormRequest
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
            'achternaam' => 'required|min:2',
            'adres' => 'required',
            'huisnummer' => 'required',
            'huisnummertoevoeging',
            'aangemeld',
            'postcode' => 'required|size:6|alpha_num',
            'woonplaats' => 'required',
            'telefoon' => 'required|numeric',
            'motivering' => 'required|min:100',
            'email' => 'required|email|unique:users,email|unique:familys,email,'.$this->get('id'),
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    public function messages()
    {
        return [
            'achternaam.required'  => 'U moet een achternaam opgeven.',
            'achternaam.min'  => 'De achternaam moet minimaal 2 karakters hebben.',
            'type.min' => 'Het type intermediair (naam van de instelling) moet minimaal 5 karakters hebben.',
            'huisnummer.required'  => 'U moet een huisnummer opgeven.',
            'postcode.required'  => 'U moet een geldige Nederlandse postcode opgeven (zoals 1234AB).',
            'adres.required'  => 'Adres kon niet worden opgehaald. Klopt de postcode of huisnummer wel?',
            'woonplaats.required'  => 'Plaats kon niet worden opgehaald. Klopt de postcode of huisnummer  wel?',
            'postcode.size'  => 'U moet een postcode opgeven (zoals 1234AB).',   
            'postcode.alpha_num'  => 'U moet een postcode opgeven (zoals 1234AB).',        
            'telefoon.required'  => 'U moet een telefoonnummer opgeven.',
            'email.required'  => 'U moet een emailadres opgeven.',
            'email.email'  => 'U heeft geen geldig emailadres opgegeven.',
            'email.unique'  => 'Het emailadres is al bekend bij ons.',
            'motivering.required'  => 'U heeft geen motivatie opgegeven.',
            'motivering.min'  => 'De motivatie moet minimaal uit 100 karakters bestaan.',
        ];
    }

}
