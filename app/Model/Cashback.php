<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Repository\BaseModelTrait;

class Cashback extends Model
{
    use BaseModelTrait;

    public function merchant()
    {
        return $this->hasOne('App\Model\Cashback_merchant','id', 'merchant_id');
    }
}
