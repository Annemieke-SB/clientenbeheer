<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

	protected $fillable = [
            'value',
	];

        const CREATED_AT = 'created_at';
        const UPDATED_AT = 'updated_at';

	static function get($key) // bv Setting::get('inschrijven_gesloten');
	{
	    $setting = self::where('setting', $key)->first();
	    return $setting->value;
	}

}
