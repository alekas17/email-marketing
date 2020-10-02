<?php

namespace App\Repository;

/**
 *
 */
trait BaseModelTrait
{
    public function getDateFormat()
    {
        if (config('database.default') == 'pgsql') {
            return 'Y-m-d H:i:s.uP';
        }
        
        return "Y-m-d H:i:s";
    }
}
