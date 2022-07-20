<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class NasaService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'nasaService';
    }
}
