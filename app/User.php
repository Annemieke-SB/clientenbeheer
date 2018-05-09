<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Settings;
use Custommade;
use App\Blacklist;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $appends = array('blacklisted');

    protected $fillable = [
        'voornaam','tussenvoegsel', 'achternaam','geslacht','organisatienaam','functie', 'email', 'password', 'email_token', 'verified', 'activated', 'reden','website', 'telefoon', 'type', 'postcode', 'huisnummer', 'huisnummertoevoeging', 'adres', 'woonplaats',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function familys()
    {
        return $this->hasMany('App\Family');
    }


    public function getBlacklistedAttribute() {
	
	    return Blacklist::check($this->email);
    }


    public function getNaamAttribute() {
	
	if (isset($this->tussenvoegsel)) {
	
	    return ucfirst($this->voornaam) . ' ' . strtolower($this->tussenvoegsel) . ' ' . ucfirst($this->achternaam); 

	} else {
	    return ucfirst($this->voornaam) . ' ' . ucfirst($this->achternaam); 
    	}
    }

    public function verified()
    {

        
        $this->emailverified = 1;
        $this->email_token = null;
        $this->save();        

        if ($this->activated == 0) {
            $to = Setting::find(5)->setting;
            Custommade::sendNewUserNotificationEmailToAdmin($to);
        }
    }

    public function destroyFamilys() {
    	if($this->familys) {
		foreach($this->familys as $family) {
			try{
				$family->destroyKids(); // Koppelt ook de barcodes los
			}
			catch(\Exception $e){
				throw new \Exception($e);	
			}
			$family->delete();
		}
	}
    }
}
