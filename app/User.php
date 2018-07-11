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

    protected $appends = array('blacklisted', 'andereinitiatieven');

    protected $fillable = [
        'voornaam','tussenvoegsel', 'achternaam','geslacht','organisatienaam','functie', 'email', 'password', 'email_token', 'verified', 'activated', 'reden','website', 'telefoon', 'type', 'postcode', 'huisnummer', 'huisnummertoevoeging', 'adres', 'woonplaats', 'nieuwsbrief',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function kids()
    {
        return $this->hasMany('App\Kid');
    }

    public function barcodes()
    {
        return $this->hasMany('App\Barcode');
    }


    public function familys()
    {
        return $this->hasMany('App\Family');
    }


    public function getBlacklistedAttribute() {
	
	    return Blacklist::check($this->email);
    }

    public function getAndereinitiatievenAttribute() {

        // check of de intermediair andere initiatieven tussen de gezinnen heeft. 

        $gezinnen = $this->familys;
        $andereinitiatieven = false;
        
        

            
               foreach ($gezinnen as $gezin) {

                    if ($gezin->andere_alternatieven == 1 && $gezin->aangemeld == 1) {

                        return true;

                    }                    
            }  
            return false;  
                  
        


        return false;
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

    public function tmptest() // dit is een test voor de adminmail. Kan weer verwijderd worden. 
    {


        $to = Setting::find(5)->setting;

        Custommade::sendNewUserNotificationEmailToAdmin($to);

        dd($to);
        
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
