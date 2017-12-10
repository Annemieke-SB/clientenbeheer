<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DNS1D;
use Custommade;
use DB;

class Barcode extends Model
{

	protected $table = 'barcodes';

    protected $appends = array('voorraad', 'totaal', 'uitgegeven', 'availablebarcode', 'htmlbarcode');

    protected $fillable = [
            'barcode',
            'kid_id', 
            'downloadedpdf'
    ];

    public function redeemed()
    {
        return $this->belongsTo('App\Redeemed', 'CardNumber', 'barcode');
    }

    public function kid()
    {
        return $this->belongsTo('App\Kid');
    }


    public function getTotaalAttribute()
    {
        return DB::table('barcodes')->count();
    }


    public function getVoorraadAttribute()
    {
        return Barcode::where('kid_id', false)->count();
    }


    public function getUitgegevenAttribute()
    {
        return $this->getTotaalAttribute - $this->getVoorraadAttribute;
    }


    public function getAvailablebarcodeAttribute()
    {
        return Barcode::where('kid_id', false)->first();
    }


    public function getHtmlbarcodeAttribute()
    {

         if ($this->barcode) {

            return DNS1D::getBarcodeHTML($this->barcode, "C128") . '<br><div id="barcodenumber">' . $this->barcode . '</div>';

         } else {

            return 'Er ging iets fout';

         }

    }   

}
