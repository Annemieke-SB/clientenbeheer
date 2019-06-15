<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Barcode;
use DNS1D;
use Custommade;


class Kid extends Model
{

	protected $table = 'kids';
    protected $appends = array('naam', 'unieknummer','targetkid', 'targetsibling', 'agenextsint', 'reasontargetkid', 'reasontargetsibling', 'disqualified', 'geboortedatumvoornaamdubbel', 'intermediairgegevens', 'familyanderealternatieven', 'htmlbarcode', 'downloadedbarcodepdf');

    protected $fillable = [
            'voornaam',
            'achternaam',
	    'tussenvoegsel',
            'family_id',
	    'user_id',
            'geslacht',
            'geboortedatum'
    ];


    public function family()
    {
        return $this->belongsTo('App\Family');
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function barcode()
    {
        return $this->hasOne('App\Barcode');
    }
 
    public function getNaamAttribute() {
	
	if (isset($this->tussenvoegsel)) {
	
	    return ucfirst($this->voornaam) . ' ' . strtolower($this->tussenvoegsel) . ' ' . ucfirst($this->achternaam); 

	} else {
	    return ucfirst($this->voornaam) . ' ' . ucfirst($this->achternaam); 
    	}
    }

  

    public function getTargetkidAttribute()
    {
        $min_leeftijd = Setting::get('min_leeftijd');
        $max_leeftijd = Setting::get('max_leeftijd');

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
        $min_leeftijd = Setting::get('min_leeftijd');
        $max_leeftijd = Setting::get('max_leeftijd');

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
        $min_leeftijd = Setting::get('max_leeftijd'); // Haal de minimum leeftijd voor sibling kind op. (max leeftijd voor een target)

        $max_leeftijd = Setting::get('max_leeftijd_broer_zus'); // Haal de maximum leeftijd voor een broer/zus op.

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
        $min_leeftijd = Setting::get('min_leeftijd');
        $max_leeftijd = Setting::get('max_leeftijd');

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

       if ($this->family->definitiefafkeuren == 1) {
            return true;
        } elseif(!$this->targetsibling && !$this->targetkid) {

            return true;

        } elseif ($this->family->targetkids==0){

            return true;
	} else {
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

            //return DNS1D::getBarcodeHTML($this->barcode->barcode, "C128") . '<br><div id="barcodenumber">' . $this->barcode->barcode . '</div>';

            return '<div id="barcodenumber">' . $this->barcode->barcode . '</div>';

         } else {

            return 'Dit kind heeft geen barcode';

         }

    }    


    public function detachBarcode()
    {

         if ($this->barcode) {
		 try{
		    $this->barcode->detach(); // try code
		} 
		 catch(\Exception $e){
		    throw new \Exception($e);	
		}	 
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
