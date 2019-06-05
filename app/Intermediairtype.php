<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ìntermediairtype extends Model
{
	protected $table = 'intermediairtypes';

	protected $fillable = [

	
	'omschrijving',
	'user_id'

	];
    //
	
    public function user()
    {
        return $this->belongsTo('App\User');
    }


}
