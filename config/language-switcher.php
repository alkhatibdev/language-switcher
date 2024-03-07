<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable/disable Package
    |--------------------------------------------------------------------------
    |
    | Set to false if you want to disable language switching at all effectively.
    | Assigned middleware may still load, but will not do anything and skip its work.
    |
     */

    'enable' => true,

    /*
    |--------------------------------------------------------------------------
    | Middleware Alias
    |--------------------------------------------------------------------------
    |
    | The middleware alias will be registered when the application is started.
    | You can assign package middleware to your routes by this alias. However,
    | feel free to rename it as you wish.
    |
    |   Example:
    |       Route::middleware(['switchlocale'])->group('/', function () {});
    |
     */

    'alias' => 'switchlocale',

    /*
    |--------------------------------------------------------------------------
    | Assign Middleware Globally
    |--------------------------------------------------------------------------
    |
    | Set to true if you want to effectively enable language switching to all routes.
    | However, when it is set to false the language switching will work only on routes that
    | assign a middleware alias.
    |
     */

    'assign_globally' => true,

    /*
    |--------------------------------------------------------------------------
    | Allowed Locales
    |--------------------------------------------------------------------------
    |
    | The array of supported locales by your application that package will toggle
    | switching only between them. If the passed locale is not in this list,
    | the fallback_locale will be set.
    |
     */

    'allowed_locales' => [
        'en',
        'ar',
        'es',
    ],

    /*
    |--------------------------------------------------------------------------
    | Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current passed
    | one not on allowed locales. You may change the value to correspond to any of
    | the allowed_locales.
    |
     */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Headers Keys
    |--------------------------------------------------------------------------
    |
    | Switching language depending on the headers of the incoming requests. This
    | is useful when working with API calls.
    |
    |   *enable*:
    |       Enable/Disable switching language via request headers keys.
    |
    |   *supported_keys*:
    |       The array of supported keys will be considered to switch the locale
    |       when they passed with request headers.
    |
    |   Example:
    |       curl --header "Accept-Language: en" https://example.com
     */

    'headers' => [
        'enable' => true,
        'supported_keys' => ['Accept-Language'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Requests Keys
    |--------------------------------------------------------------------------
    |
    | Switching language depending on the body/query keys of the incoming requests.
    |
    |   *enable*:
    |       Enable/Disable switching language via request body/query keys.
    |
    |   *supported_keys*:
    |       The array of supported keys will be considered to switch the locale
    |       when they passed with request body/query.
    |
    |   *enable_magic_keys*:
    |       Enable/Disable switching language via request magic keys.
    |       Magic key: is request query parameter without value.
    |
    |   *magic_keys_prefix*:
    |       The magic keys prefix will be concatenated with each of the allowed locales to give a special name.
    |       You can set to '_', '-' or '@'. default value is ''.
    |       Note: Only request query params supported characters are allowed.
    |
    |   Examples:
    |       - example.com/?lang=en                      // with supported keys
    |       - example.com/?en                           // with magic keys
    |       - example.com/?_en                          // with magic keys and prefix
    |       All examples above will ask the package to switch locale to 'en'
     */

    'requests' => [
        'enable' => true,
        'supported_keys' => ['lang', 'locale'],

        'enable_magic_keys' => true,
        'magic_keys_prefix' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Parameters
    |--------------------------------------------------------------------------
    |
    | Switching language depending on the current route parameters. This is
    | useful for SEO.
    |
    |   *enable*:
    |       Enable/Disable switching language via route parameters.
    |
    |   *supported_parameters*:
    |       The array of supported parameter names will be considered to switch
    |       locale when they are defined in the current request route.
    |
    |   Example:
    |       - For given route: Route::get('/{locale}/home', [HomeController, 'home']);
    |       Calling example.com/en/home will ask the package to switch locale to 'en'.
     */

    'routes' => [
        'enable' => true,
        'supported_parameters' => ['locale', 'lang'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Session
    |--------------------------------------------------------------------------
    |
    | The package may use sessions to store the current locale, switched by a user,
    | to keep the newly selected locale active for the next requests without a need to pass
    | the locale in every request.
    |
    |   *enable_session*:
    |       Enable/Disable storing the current switched user locale.
    |
    |   *session_key*:
    |       Session key used to store current locale. Feel free to change its value
    |       to any valid string that does not interrupt your application sessions' names.
    |
     */

    'enable_session' => true,
    'session_key' => 'switch_locale_key',

];
