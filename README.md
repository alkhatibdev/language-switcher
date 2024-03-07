<p align="center"><img src="https://raw.githubusercontent.com/alkhatibdev/language-switcher/main/socialcard.png" alt="Social Card of Language Switcher Package"></p>

# Laravel dynamic language switcher

[![Latest Version](https://img.shields.io/github/release/alkhatibdev/language-switcher.svg?style=flat-square)](https://github.com/alkhatibdev/language-switcher/releases)
![Packagist Downloads (custom server)](https://img.shields.io/packagist/dt/alkhatibdev/language-switcher)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

# Introduction
Laravel dynamic language switcher for both web and API routes with various supported options.

## Features

- Switch user locale automatically and remind newly selected language for all next requests.
- Support language switching via `request body/query keys`, `request headers keys`, and `route parameters names`.
- Support API routes (Switch language via headers for stateless requests).
- Support all HTTP methods (GET, POST, PUT and ..etc).
- SEO-friendly routes by supporting language switching depending on route parameters.
- Everything is configurable with a rich and well-documented [configuration file](https://github.com/alkhatibdev/language-switcher/blob/main/config/language-switcher.php).

# Installation

## install via composer

```bash
composer require alkhatibdev/language-switcher
```

## Publish Configs 
```bash
php artisan vendor:publish --tag=language-switcher-config
```
A `language-switcher.php` config file will be published on your `configs` directory. Feel free to read and override all these configurable parts, or stick with the [defaults configs](https://github.com/alkhatibdev/language-switcher/blob/main/config/language-switcher.php)

<br>

# Usage

## Basic Usage
Everything is set out of the box, start calling your routes with these supported options:

### Via Request query/body keys
```bash
// Request query key/value
http://example.com/?lang=en

// Request magic keys
http://example.com/?en

// Also you can use the same above parameters with the body of POST or PUT
curl -X POST http://example.com/api/users
     -d '{"lang": "en"}'  
```


### Via request headers keys
```bash
curl --header "Accept-Language: en" http://example.com/api/users
```

### Via route parameters 
For given route: `Route::get('/{locale}/home', [HomeController, 'home']);`

```
http://example.com/en/home
```

<br>

> **Note**
> <br>- All previous examples will ask the package to switch locale to `'en'`.
> <br>- Upcoming requests still remind this newly set locale.

<br>

## Customize Package Scope

By default, the package middleware is assigned globally to all your routes. However, you can disable `assign_globally` from the package config file, and assign middleware `alias` to all routes and route groups manually.

### Disable global assignment
```php
// config/language-switcher.php

'assign_globally' => false,
```

### Assign to route or route groups
```php
// routes/web.php

// Assign to individual route
Route::get('/{locale}/home', [HomeController, 'home'])->middleware(['switchlocale']);


// Assign to route group
Route::->middleware(['switchlocale'])->group(function () {
    //
});
```

### Assign to middleware groups
```php
// app/Http/kernel.php

protected $middlewareGroups = [
    'web' => [
        // ...
        'switchlocale',
    ],

    'api' => [
        // ...
        'switchlocale',
    ],
];
```

### Disable Saving

By default, the package uses sessions to store the current locale, switched by a user, to keep the newly selected locale active for the next requests without a need to pass the locale in every request. However, if you want to stop this behavior, set `enable_session` to `false`.


```php
// config/language-switcher.php

'enable_session' => false,
```

<br>

# License

Language Switcher is open-sourced software licensed under the [MIT license](LICENSE).
