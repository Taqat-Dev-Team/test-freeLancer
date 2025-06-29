<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $supportedLocales = LaravelLocalization::getSupportedLanguagesKeys();
        $defaultLocale = config('app.locale', 'en');
        $locale = $defaultLocale;

        $headerLocale = $request->getPreferredLanguage($supportedLocales);

        if ($headerLocale && in_array($headerLocale, $supportedLocales)) {
            $locale = $headerLocale;
        }

//        حفظ لغة الهيدر في جدول المستخدم
        if (Auth::check()) {
            $user = Auth::user();
            $user->lang = $locale;
            $user->save();
        }

        // 2. تعيين اللغة في Laravel و LaravelLocalization
        app()->setLocale($locale);
        LaravelLocalization::setLocale($locale);

        return $next($request);
    }


}
