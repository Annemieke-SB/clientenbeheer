<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{

	protected $table = 'familys';
    protected $appends = array('targetkids', 'targetsiblings', 'kidsdisqualified', 'kidscount', 'disqualified', 'postcodehuisnummerdubbel', 'heeftkindmogelijkdubbel');

    protected $fillable = [
            'achternaam',
            'adres',
            'huisnummer',
            'huisnummertoevoeging',
            'postcode',
            'woonplaats',
            'telefoon',
            'email',
            'password',
            'intertoy_id',
            'bezoek_sintpiet',
            'motivering',
            'andere_alternatieven',
            'user_id',
            'intertoy_id',
            'aangemeld',
            'goedgekeurd'
    ];

	
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function kids()
    {
        return $this->hasMany('App\Kid');
    }

    public function intertoys()
    {
        return $this->hasOne('App\Intertoys', 'id', 'intertoy_id');
    }

    public function getTargetkidsAttribute()
    {
        $kids = $this->kids;
        $count = 0;

        foreach ($kids as $kid) {
            if ($kid->targetkid) {
                $count++;
            }
        }
        return $count;
        
    }

    public function getTargetsiblingsAttribute()
    {
        $kids = $this->kids;
        $count = 0;

        foreach ($kids as $kid) {
            if ($kid->targetsibling) {
                $count++;
            }
        }
        return $count;
        
    }

    public function getKidsdisqualifiedAttribute()
    {
        $kids = $this->kids;
        $count = 0;

        foreach ($kids as $kid) {
            if ($kid->disqualified) {
                $count++;
            }
        }
        return $count;        
    }

    public function getKidscountAttribute()
    {
        $kids = $this->kids;
        $count = 0;

        foreach ($kids as $kid) {
           
                $count++;
        
        }
        return $count;        
    }

    public function getDisqualifiedAttribute()
    {
        if ($this->kidscount == $this->kidsdisqualified) {
            return true;
        }       
        else {
            return false;
        }
    }

    public function getPostcodehuisnummerdubbelAttribute()
    {


     $fams = Family::where([
        ['postcode', '=', $this->postcode],
        ['huisnummer', '=', $this->huisnummer]
        ])->get();

        if (count($fams)==1) {
            return false; //als er maar 1 is, dan is er geen dubbele
        }       
        else {
            return $fams;
        }
    }

    public function getHeeftkindmogelijkdubbelAttribute()
    {

        $kids = $this->kids;
        $count = 0;

        foreach ($kids as $kid) {
            if ($kid->geboortedatumvoornaamdubbel) {
                $count++;
            }
        }
        return $count;        
    
    }

}
