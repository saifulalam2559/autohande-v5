<?php

namespace App\Helpers;

use App\Models\Auto;
use Carbon\Carbon;

class Helper
{
    public static function userDefaultImage()
    {
        return asset('frontend/images/default.png');
    }

    /*
    |--------------------------------------------------------------------------
    | PRICE
    |--------------------------------------------------------------------------
    */

    public static function minPrice()
    {
        return floor(Auto::min('price'));
    }

    public static function maxPrice()
    {
        return ceil(Auto::max('price'));
    }


    /*
    |--------------------------------------------------------------------------
    | MILEAGE / KILOMETER
    |--------------------------------------------------------------------------
    */

    public static function minMileage()
    {
        return floor(Auto::min('mileage'));
    }

    public static function maxMileage()
    {
        return ceil(Auto::max('mileage'));
    }
    
    
     /*
    |--------------------------------------------------------------------------
    | First Registration Minimum Year
    |--------------------------------------------------------------------------
    */

    public static function minRegistrationYear()
    {
        $minDate = Auto::whereNotNull('first_registration')
            ->min('first_registration');

        if (!$minDate) {
            return date('Y');
        }

        return Carbon::parse($minDate)->year;
    }

    /*
    |--------------------------------------------------------------------------
    | First Registration Maximum Year
    |--------------------------------------------------------------------------
    */

    public static function maxRegistrationYear()
    {
        $maxDate = Auto::whereNotNull('first_registration')
            ->max('first_registration');

        if (!$maxDate) {
            return date('Y');
        }

        return Carbon::parse($maxDate)->year;
    }
    
    
    
    public static function minPowerHp() 
    { 
        return floor(Auto::min('power_hp')); 
    
    } 
    
    public static function maxPowerHp() 
    { 
        return ceil(Auto::max('power_hp')); 
        
    }
    
    
    
}

