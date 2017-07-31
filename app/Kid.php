<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Barcode;
use DNS1D;
use Custommade;


class Kid extends Model
{

	protected $table = 'kids';
    protected $appends = array('unieknummer','targetkid', 'targetsibling', 'agenextsint', 'reasontargetkid', 'reasontargetsibling', 'disqualified', 'geboortedatumvoornaamdubbel', 'intermediairgegevens', 'familyanderealternatieven', 'htmlbarcode', 'downloadedbarcodepdf');

    protected $fillable = [
            'achternaam',
            'voornaam',
            'family_id',
            'geslacht',
            'geboortedatum'
    ];


    public function family()
    {
        return $this->belongsTo('App\Family');
    }


    public function barcode()
    {
        return $this->hasOne('App\Barcode');
    }
   

    public function getTargetkidAttribute()
    {
        $setting = Setting::find(1); // Haal de minimum leeftijd voor een kind op.
        $min_leeftijd =  $setting->getValue();

        $setting = Setting::find(2); // Haal de maximum leeftijd voor een kind op.
        $max_leeftijd =  $setting->getValue();

        if ($this->agenextsint > $max_leeftijd) {
          
            return false;
        } elseif ($this->agenextsint < $min_leeftijd) {
            
            return false;
        } else {
           
            return true;
        }  
    }

 

    public function getReasontargetkidAttribute()
    {

        $setting = Setting::find(1); // Haal de minimum leeftijd voor een kind op.
        $min_leeftijd =  $setting->getValue();

        $setting = Setting::find(2); // Haal de maximum leeftijd voor een kind op.
        $max_leeftijd =  $setting->getValue();

        if ($this->agenextsint > $max_leeftijd) {
            return "Dit kind is te oud.";
          
        } elseif ($this->agenextsint < $min_leeftijd) {
            return "Dit kind is te jong.";
          
        } else {
            return "Dit kind valt binnen de leeftijdsgrens."; 
        }
    }


    public function setGeboortedatumAttribute($value)
    {
        $time = strtotime($value);
        $this->attributes['geboortedatum'] = date('d-m-Y',$time);  
    }


    public function getAgenextsintAttribute()
    {
        $volgendSinterklaasJaar = Custommade::returnNextSinterklaasJaar();
        $volgendSinterklaas = "12/5/". $volgendSinterklaasJaar;
        return date_diff(date_create($this->geboortedatum), date_create($volgendSinterklaas))->y;        
    }


   public function getTargetsiblingAttribute()
    {
        $setting = Setting::find(2); // Haal de minimum leeftijd voor sibling kind op.
        $min_leeftijd =  $setting->getValue();

        $setting = Setting::find(3); // Haal de maximum leeftijd voor een broer/zus op.
        $max_leeftijd =  $setting->getValue();

        if ($this->agenextsint > $max_leeftijd) {          
            return false;
        } elseif ($this->agenextsint <= $min_leeftijd) {            
            return false;
        } else {           
            return true;
        }  
    }


    public function getReasontargetsiblingAttribute()
    {

        $setting = Setting::find(1); // Haal de minimum leeftijd voor een kind op.
        $min_leeftijd =  $setting->getValue();

        $setting = Setting::find(2); // Haal de maximum leeftijd voor een kind op.
        $max_leeftijd =  $setting->getValue();

        if ($this->agenextsint > $max_leeftijd) {
            return "Dit kind is te oud.";
          
        } elseif ($this->agenextsint <= $min_leeftijd) {

            return "Dit kind is te jong.";      

        } else {

            return "Dit kind valt binnen de leeftijdsgrens.";   
        }

    }

    public function getDisqualifiedAttribute()
    {
        $family = Family::find($this->family_id);


        if ($family->targetkids==0) {

            return true;

        } elseif ($family->motivering != NULL && $family->goedgekeurd==0) {
            return true;
        } elseif(!$this->targetsibling && !$this->targetkid) {

            return true;

        } elseif ($this->targetkid){

            return false;
        }
    }


    public function getFamilyanderealternatievenAttribute()
    {
        $family = Family::find($this->family_id);

        if ($family->andere_alternatieven==1) {

            return true;

        } else {

            return false;

        }
    
    }    


    public function getGeboortedatumvoornaamdubbelAttribute()
    {

        $kids = Kid::where([
            ['geboortedatum', '=', $this->geboortedatum],
            ['voornaam', '=', $this->voornaam]
            ])->get();

        if (count($kids)==1) {

            return false; //als er maar 1 is, dan is er geen dubbele

        }       
        else {

            return $kids;

        }


    }


    public function getUnieknummerAttribute()
    {

        $num_str = sprintf("%05d", $this->id);
        return $this->agenextsint . $num_str;
    }    


    public function getIntermediairgegevensAttribute()
    {

         $fam = Family::where('id', $this->family_id)->first();
         $intermediair = Intermediair::where('id', $fam->intermediair_id)->first();
         $user = User::where('id', $intermediair->user_id)->first();

         //return $user->name . " (" . $intermediair->type . ") - " . $user->email . " | " . $intermediair->telefoon;  
         return $intermediair;
    }


    public function getAchternaamAttribute($value)
    {

         $fam = Family::where('id', $this->family_id)->first();

         if (!$value) {

            return $fam->achternaam;

         }

        return $value;  

    }    


    /*
    * 
    * Als het kind een barcode heeft gekregen kan hier de html-barcode worden opgevraagd.
    *
    */

    public function getHtmlbarcodeAttribute()
    {

         if ($this->barcode) {

            return DNS1D::getBarcodeHTML($this->barcode->barcode, "C128") . '<br><div id="barcodenumber">' . $this->barcode->barcode . '</div>';

         } else {

            return 'Dit kind heeft geen barcode';

         }

    }    


    public function getDownloadedbarcodepdfAttribute()
    {

         if ($this->barcode) {

            return $this->barcode->downloadedpdf;

         } else {

            return 'Dit kind heeft geen barcode';

         }
    }  


    public function setDownloadedbarcodepdfAttribute($val)
    {

         if ($this->barcode) {         

            $this->barcode->downloadedpdf = $val;
            $this->barcode->save();

         } else {

            return 'Dit kind heeft geen barcode';

         }
    }    


}
