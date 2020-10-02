<?php

namespace App\Model\Merchant;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    //
    public function merchant()
    {
        return $this->hasOne('App\Model\Cashback_merchant');
    }

    public function age_ranges()
    {
        return $this->hasMay('App\Model\Merchant\OfferAgeRange');
    }
}
