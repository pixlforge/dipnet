<?php

namespace App\Http\Hashids;

use Hashids\Hashids;

class HashidsGenerator
{
    private static $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function generateFor($id, $salt = 'dipnet')
    {
        $hashids = new Hashids($salt, 8, self::$alphabet);
        
        return $hashids->encode($id);
    }
}
