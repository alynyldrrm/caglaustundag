<?php

namespace App\Http\Middleware;

use App\Models\Language;
use App\Models\Type;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class setDefaults
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentLanguage = Language::where('key', App::getLocale())->first();
        $languages = Language::get();
        $types = Type::orderBy('sort', 'ASC')->get();
        $sessionData = [
            "languages" => $languages,
            "types" => $types,
            "currentLanguage" => $currentLanguage
        ];
        Session::put('defaultDatas', $sessionData);
        return $next($request);
    }
}
