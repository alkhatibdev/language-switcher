<?php

namespace AlkhatibDev\LanguageSwitcher;

use Illuminate\Support\Facades\App;

class LanguageSwitcher
{

    /**
     * Create LanguageSwitcher instance
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the current application locale.
     *
     * @return string
     */
    public function locale()
    {
        return App::getLocale();
    }
}
