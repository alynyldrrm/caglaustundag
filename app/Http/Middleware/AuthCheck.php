<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $type = "admin"): Response
    {
        if ($type == "admin" && !Auth::user()) {
            return redirect()->route('login.get');
        }
        if ($type == "client" && !Auth::user()) {
            return redirect()->back();
        }
        return $next($request);
    }
}
