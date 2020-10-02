<?php

namespace App\Model\Merchant\Offers;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    //
    protected $table = "offers_gender";

    protected function offer(){
        return $this->belongsTo(Offer::class);
    }
}
