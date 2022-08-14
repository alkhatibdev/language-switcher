<?php

namespace AlkhatibDev\LanguageSwitcher\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SwitchLocale
{
    /**
     * Incoming request
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Loaded package configs
     *
     * @var array
     */
    protected $configs = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $this->request = $request;

        if (config('language-switcher.enable', false)) {
            $this->loadConfigs();
            $this->handleSwitchDefaultLocal($this->request);
        }

        return $next($this->request);
    }

    /**
     * Check configs and Hhandle locale switching logic
     *
     * @param \Illuminate\Http\Request  $request
     * @return void
     */
    private function handleSwitchDefaultLocal(Request $request)
    {
        $locale = $this->getCurrentLocale();

        if ($this->configs['requestKeysEnabled']) {
            foreach ($this->configs['supportedRequestKeys'] as $requestLangKey) {
                if ($request->has($requestLangKey) and in_array($request->input($requestLangKey), $this->configs['allowedLocales'])) {
                    $locale = $request->input($requestLangKey);
                }
            }
        }

        if ($this->configs['requestMagicKeysEnabled']) {
            foreach ($this->configs['allowedLocales'] as $code) {
                if ($request->has($this->configs['requestMagicKeysPrefix'] . $code)) {
                    $locale = $code;
                }
            }
        }

        if ($this->configs['routeParametersEnabled']) {
            foreach ($this->configs['routeParameters'] as $routeParameter) {
                if (!is_null($request->route($routeParameter)) and in_array($request->route($routeParameter), $this->configs['allowedLocales'])) {
                    $locale = $request->route($routeParameter);
                }
            }
        }

        if ($this->configs['headersKeysEnabled']) {
            foreach ($this->configs['supportedHeaderKeys'] as $headerKey) {
                if (in_array($request->headers->get($headerKey), $this->configs['allowedLocales'])) {
                    $locale = $request->headers->get($headerKey);
                }
            }
        }

        $this->setLocale($locale);
    }

    /**
     * Get current locale
     *
     * @return string
     */
    private function getCurrentLocale()
    {
        if ($this->configs['sessionEnabled']) {
            return Session::get($this->configs['sessionKey'], $this->configs['fallbackLocale']);
        }

        return App::getLocale();
    }

    /**
     * Set application locale
     *
     * @param string  $locale
     * @param string  $sessionKey
     * @return void
     */
    private function setLocale(string $locale)
    {
        App::setLocale($locale);
        $this->request->setLocale($locale);

        if ($this->configs['sessionEnabled']) {
            Session::put($this->configs['sessionKey'], $locale);
        }
    }

    /**
     * Load package configs
     *
     * @return array
     */
    private function loadConfigs()
    {
        $this->configs = [
            'allowedLocales' => config('language-switcher.allowed_locales'),
            'requestKeysEnabled' => config('language-switcher.requests.enable', false),
            'supportedRequestKeys' => config('language-switcher.requests.supported_keys'),
            'headersKeysEnabled' => config('language-switcher.headers.enable', false),
            'supportedHeaderKeys' => config('language-switcher.headers.supported_keys'),
            'requestMagicKeysEnabled' => config('language-switcher.requests.enable_magic_keys', false),
            'requestMagicKeysPrefix' => config('language-switcher.requests.magic_keys_prefix'),
            'routeParametersEnabled' => config('language-switcher.routes.enable', false),
            'routeParameters' => config('language-switcher.routes.supported_parameters'),
            'fallbackLocale' => config('language-switcher.fallback_locale'),
            'sessionEnabled' => config('language-switcher.enable_session', false),
            'sessionKey' => config('language-switcher.session_key', false),
        ];
    }
}
