<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'voornaam','achternaam','geslacht','organisatienaam','functie', 'email', 'password', 'email_token', 'verified', 'activated', 'reden','website', 'telefoon',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function intermediair()
    {
        return $this->hasOne('App\Intermediair');
    }

    public function verified()
    {

        
        $this->emailverified = 1;
        $this->email_token = null;
        $this->save();        

        if ($this->activated == 0) {
            Custommade::sendNewUserNotificationEmailToAdmin();
        }
    }
}
