<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Priority: URL prefix > Session > User preference > Config default
        $locale = $request->segment(1);

        if (in_array($locale, ['en', 'ta'])) {
            app()->setLocale($locale);
            session()->put('locale', $locale);
        } else {
            $locale = session('locale', $request->user()?->locale ?? config('app.locale'));

            if (in_array($locale, ['en', 'ta'])) {
                app()->setLocale($locale);
            }
        }

        return $next($request);
    }
}
