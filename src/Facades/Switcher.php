<?php

namespace AlkhatibDev\LanguageSwitcher\Facades;

use Illuminate\Support\Facades\Facade;

/**
* @method static string locale()
*
* @see \AlkhatibDev\LanguageSwitcher\Switcher
*/
class Switcher extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'switcher';
    }

}
