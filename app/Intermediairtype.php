<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intermediairtype extends Model
{
	protected $table = 'intermediairtypes';

	protected $fillable = [

	
	'omschrijving',

	];
    //
	
    public function user()
    {
        return $this->hasMany('App\User');
    }


}
