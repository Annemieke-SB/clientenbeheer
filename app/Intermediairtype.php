<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faqs extends Model
{
	protected $table = 'faqs';

	protected $fillable = [

	'vraag',
	'antwoord',
	'category',
	'user_id'

	];
    //
	
    public function user()
    {
        return $this->belongsTo('App\User');
    }


}
