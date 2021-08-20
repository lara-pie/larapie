<?php

namespace Larapie\Larapie\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed safe($value)
 */
class Larapie extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'larapie';
    }
}
