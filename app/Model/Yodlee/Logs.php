<?php

namespace App\Model\Yodlee;

use Illuminate\Database\Eloquent\Model;
use App\Repository\BaseModelTrait;

class Logs extends Model
{
    use BaseModelTrait;

    protected $table = "yodlee_logs";
    protected $fillable = ["*"];

    public function transactions()
    {
        return $this->hasMany('App\Model\Yodlee\Transactions');
    }
}
