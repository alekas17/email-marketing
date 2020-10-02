<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Repository\BaseModelTrait;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, BaseModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        "last_name",
        "phone",
        "cashback_register",
        "lightrail_uuid",
        "lightrail_value_uuid",
        "gender",
        "age_bracket",
        "referred_by"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function merchant()
    {
        return $this->hasOne('App\Model\Cashback_merchant', 'user_id', 'id');
    }
}
