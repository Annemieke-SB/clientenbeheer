<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intermediairtype extends Model
{
	protected $table = 'intermediairtypes';

	protected $appends = array('aantal', 'formulierlijst');

	protected $fillable = [
	
	'omschrijving',

	];
    //
	
    public function user()
    {
        return $this->hasMany('App\User');
    }


	public function getAantalAttribute() {
	    $users = $this->users();
	    return count($users);
	}

}
