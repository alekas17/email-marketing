<?php

namespace App\Model\Merchant\Offers;

use Illuminate\Database\Eloquent\Model;

class AgeRange extends Model
{
    //
    protected $table = "offers_age_range";

    protected function offer(){
        return $this->belongsTo(Offer::class);
    }
}
