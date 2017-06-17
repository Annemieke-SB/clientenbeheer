<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intermediair extends Model
{
    protected $appends = array('disqualifiedkids', 'disqualifiedfams', 'famheeftpostcodehuisnummerdubbel', 'dubbelkind', 'hasfams', 'hasfamszonderkids', 'nietaangemeldefams');

	protected $fillable = [
            'naam',
            'type',
            'adres',
            'huisnummer',
            'huisnummertoevoeging',
            'postcode',
            'woonplaats',
            'user_id',
	];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

        /**
     * Get the comments for the blog post.
     */
    public function familys()
    {
        return $this->hasMany('App\Family');
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function kids()
    {
        return $this->hasManyThrough('App\Kid', 'App\Family');
    }


    public function getDisqualifiedkidsAttribute()
    {
        $fams = $this->familys;

        $count = 0;

        foreach ($fams as $fam) {
            $count = $count + $fam->kidsdisqualified;
        }

        return $count;        
    }


    public function getDisqualifiedfamsAttribute()
    {
        $fams = $this->familys;
        $count = 0;

        foreach ($fams as $fam) {
            if ($fam->disqualified) {
                $count++;
            }
        }
        return $count;        
    }


    public function getFamheeftpostcodehuisnummerdubbelAttribute()
    {
        $fams = $this->familys;
        $count = 0;

        foreach ($fams as $fam) {
            if ($fam->postcodehuisnummerdubbel) {
                $count++;
            }
        }
        return $count;        
    }


    public function getDubbelkindAttribute()
    {
        $fams = $this->familys;
        $count = 0;

        foreach ($fams as $fam) {

            $kids = Kid::where([
            ['family_id', '=', $fam->id]
            ])->get();

             foreach ($kids as $kid) {
                if ($kid->geboortedatumvoornaamdubbel) {
                    $count++;
                    }                 # code...
             }

        }
        return $count;        
    }  

    public function getHasfamsAttribute()
    {
        $fams = $this->familys;
        $count = 0;

        foreach ($fams as $fam) {
            $count++;
        }
        return $count;    
    }   


    public function getHasfamszonderkidsAttribute()
    {
        $fams = $this->familys;
        $count = 0;

        foreach ($fams as $fam) {
            if ($fam->kidscount == 0){
               $count++; 
           }            
        }
        return $count;    
    }  

    public function getNietaangemeldefamsAttribute()
    {
        $fams = $this->familys;
        $count = 0;

        foreach ($fams as $fam) {
             
            if (!$fam->aangemeld) {
                $count++;
            }                 
             
        }
        return $count;        
    }  
          
}
