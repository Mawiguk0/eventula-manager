<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;
use Illuminate\Support\Facades\Auth;
use App\Libraries\Helpers;
use App\Libraries\Settings;

class LanguageSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $setlocale = config('app.locale');
        if ($locale = Settings::getSiteLocale()) {

            if (!empty($locale) && Helpers::isValidLocale($locale)) {
                $setlocale = $locale;
            }
        }

        if (Auth::check() && Auth::user() && Settings::isUserLocaleEnabled()) {
            if ($userLocale = Auth::user()->locale) {
                if (!empty($userLocale) && Helpers::isValidLocale($userLocale)) {
                    $setlocale = $userLocale;
                }
            }
        }

        app()->setLocale($setlocale);
        app()->setFallbackLocale(config('app.fallback_locale'));

        return $next($request);
    }
}
