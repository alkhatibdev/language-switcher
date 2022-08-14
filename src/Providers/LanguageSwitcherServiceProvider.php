<?php

namespace AlkhatibDev\LanguageSwitcher\Providers;

use AlkhatibDev\LanguageSwitcher\Http\Middleware\SwitchLocale;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class LanguageSwitcherServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSwither();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        $this->registerConfig();
        $this->registerPublishables();
        $this->registerMiddlewares($kernel);
        $this->registerMiddlewaresAliases($kernel);
    }

    /**
     * Register Switcher facade
     *
     * @return void
     */
    public function registerSwither()
    {
        $this->app->singleton('switcher', function ($app) {return new \AlkhatibDev\LanguageSwitcher\LanguageSwitcher();});
    }

    /**
     * Register package configuration file
     *
     * @return void
     */
    public function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/language-switcher.php', 'language-switcher');
    }

    /**
     * Register publishable resources
     *
     * @return void
     */
    protected function registerPublishables()
    {
        $this->publishes([
            __DIR__ . '/../../config/language-switcher.php' => config_path('language-switcher.php'),
        ], 'language-switcher-config');
    }

    /**
     * Register package middlewares
     *
     * @return void
     */
    public function registerMiddlewares(Kernel $kernel)
    {
        if (config('language-switcher.assign_globally', false)) {
            $kernel->pushMiddleware(SwitchLocale::class);
        }
    }

    /**
     * Register package middlewares aliases
     *
     * @return void
     */
    public function registerMiddlewaresAliases()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware(config('language-switcher.alias'), SwitchLocale::class);
    }
}
