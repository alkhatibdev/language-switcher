<?php

namespace AlkhatibDev\LanguageSwitcher\Tests\Unit;

use AlkhatibDev\LanguageSwitcher\Http\Middleware\SwitchLocale;
use AlkhatibDev\LanguageSwitcher\Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

class SwitchLocaleMiddlewareTest extends TestCase
{
    /**
     * @notes:
     *
     * - Default package locale is `en` English
     * - Testing switching to `ar` Arabic locale
     */

    /** @test */
    public function it_switch_both_application_and_request_locale()
    {
        $request = new Request();
        $request->merge(['lang' => 'ar']);

        (new SwitchLocale())->handle($request, function ($request) {
            $this->assertEquals(App::getlocale(), 'ar');
            $this->assertEquals($request->getLocale(), 'ar');
        });
    }

    /** @test */
    public function it_skip_locale_switching_when_package_disabled()
    {
        $this->app['config']->set('language-switcher.enable', false);

        $request = new Request();
        $request->merge(['lang' => 'ar']);

        (new SwitchLocale())->handle($request, function ($request) {
            $this->assertNotEquals(App::getlocale(), 'ar');
        });
    }

    /** @test */
    public function it_switch_application_locale_from_request_keys()
    {
        $request = new Request();
        $request->merge(['lang' => 'ar']);

        (new SwitchLocale())->handle($request, function ($request) {
            $this->assertEquals(App::getlocale(), 'ar');
        });
    }

    /** @test */
    public function it_ignore_locale_switching_when_request_keys_disabled()
    {
        $this->app['config']->set('language-switcher.requests.enable', false);

        $request = new Request();
        $request->merge(['lang' => 'ar']);

        (new SwitchLocale())->handle($request, function ($request) {
            $this->assertNotEquals(App::getlocale(), 'ar');
        });
    }

    /** @test */
    public function it_switch_application_locale_from_request_magic_keys()
    {
        $request = new Request();
        $request->merge(['ar' => '']);

        (new SwitchLocale())->handle($request, function ($request) {
            $this->assertEquals(App::getlocale(), 'ar');
        });
    }

    /** @test */
    public function it_ignore_locale_switching_when_request_magic_keys_disabled()
    {
        $this->app['config']->set('language-switcher.requests.enable_magic_keys', false);

        $request = new Request();
        $request->merge(['ar' => '']);

        (new SwitchLocale())->handle($request, function ($request) {
            $this->assertNotEquals(App::getlocale(), 'ar');
        });
    }

    /** @test */
    public function it_switch_application_locale_from_headers_keys()
    {
        $request = new Request();
        $request->headers->set('Accept-Language', 'ar');

        (new SwitchLocale())->handle($request, function ($request) {
            $this->assertEquals(App::getlocale(), 'ar');
        });
    }

    /** @test */
    public function it_ignore_locale_switching_when_headers_keys_disabled()
    {
        config(['language-switcher.headers.enable' => false]);

        $request = new Request();
        $request->headers->set('Accept-Language', 'ar');

        (new SwitchLocale())->handle($request, function ($request) {
            $this->assertNotEquals(App::getlocale(), 'ar');
        });
    }

    /** @test */
    public function it_switch_application_locale_from_route_params()
    {
        Route::get('{locale}/test/', function (Request $request, $locale) {
            return App::getLocale();
        })->middleware('switchlocale');

        $response = $this->get('/ar/test/');
        $response->assertSeeText('ar');
    }

    /** @test */
    public function it_ignore_locale_switching_when_route_params_disabled()
    {
        Route::get('{locale}/test/', function (Request $request, $locale) {
            return App::getLocale();
        })->middleware('switchlocale');

        $this->app['config']->set('language-switcher.routes.enable', false);

        $response = $this->get('/ar/test/');
        $response->assertDontSeeText('ar');
    }
}
