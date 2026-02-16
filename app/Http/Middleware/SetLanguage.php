<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $url = explode('/', substr($request->getPathInfo(), 1));
        $langKey = $url[0];
        $ignoredRoutes = ["admin", "logout"];
        /* Sonradan eklenecek ignore rotalar
        $ignoredRoutes[] = "example_route";
        */
        if (!in_array($langKey, $ignoredRoutes)) {
            $languages = Language::get();
            $langArr = $languages->pluck('key')->toArray();
            if ($langKey != "") {
                if (in_array($langKey, $langArr)) {
                    App::setLocale($langKey);
                    Session::put("locale", $langKey);
                } else {
                    abort(404);
                    // if (Session::has('locale')) {
                    //     App::setLocale(Session::get('locale'));
                    // } else {
                    //     $defaultLang = $languages->where('is_default', true)->first();
                    //     App::setLocale($defaultLang->key);
                    // }
                }
            }
        }
        return $next($request);
    }
}
