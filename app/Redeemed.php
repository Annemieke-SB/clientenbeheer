<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DNS1D;
use Custommade;

class Redeemed extends Model
{

	protected $table = 'redeemed';

    protected $appends = array();

    protected $fillable = [
    ];


    public function barcode()
    {
        return $this->belongsTo('App\Barcode', 'barcode', 'CardNumber');
    }



}
