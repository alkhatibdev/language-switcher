<?php

namespace AlkhatibDev\LanguageSwitcher\Tests;

use AlkhatibDev\LanguageSwitcher\Providers\LanguageSwitcherServiceProvider;
use Illuminate\Support\Facades\App;
use \Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Test Default locale
        App::setlocale('en');
    }

    protected function getPackageProviders($app)
    {
        return [
            LanguageSwitcherServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        //
    }
}
