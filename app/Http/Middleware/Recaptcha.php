<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Recaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        if (!$request["g-recaptcha-response"]) {
            return redirect()->back()->with('userError', "Captcha Doğrulanamadı.");
        }
        $recaptcha3url =  'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode('6LeVU80rAAAAAEtPnBzXjc4ilZ5g5GANVkaHiUJa') .  '&response=' . urlencode($request["g-recaptcha-response"]);
        $response = file_get_contents($recaptcha3url);
        $responseKeys = json_decode($response, true);
        if ($responseKeys["success"] == false || $responseKeys["score"] < 0.5) {
            return redirect()->back()->with('userError', "Captcha Doğrulanamadı.");
        }
        return $next($request);
    }
}
