<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
	protected $table = 'blacklist';

	protected $fillable = [

	'email',
	'reden',
	'user_id'

	];
    //
	
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    static function check($email)
    {	
	    try{
	    	$e = self::where('email', $email)->firstOrFail();
	    	return true;
	    }
	    catch(\Exception $e){
	    	return false;
	    }
	    
    }
}
