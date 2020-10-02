<?php

namespace App\Model\Merchant\Offers;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    //
    protected function Cashback_merchant()
    {
        return $this->belongsTo(\App\Model\Cashback_merchant::class);
    }

    protected function age_ranges()
    {
        return $this->hasMany(AgeRange::class);
    }

    protected function genders()
    {
        return $this->hasMany(Gender::class);
    }
    
}
