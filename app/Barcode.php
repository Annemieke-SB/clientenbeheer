<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Barcode extends Model
{

	protected $table = 'barcodes';

    protected $appends = array('voorraad', 'totaal', 'uitgegeven', 'availablebarcode');

    protected $fillable = [
            'barcode',
            'kid_id', 
            'downloadedpdf'
    ];


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



}