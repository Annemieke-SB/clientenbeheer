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

	public function getValue()
	{
	    return $this->value;
	}

}
