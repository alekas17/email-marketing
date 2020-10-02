<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Repository\BaseModelTrait;

class Cashback_merchant extends Model
{
    use BaseModelTrait;

    public function user()
    {
        return $this->hasOne('App\User','id', 'user_id');
    }

    public function offers(){
        return $this->hasMany(\App\Model\Merchant\Offers\Offer::class, "merchant_id", "id");
    }
}
