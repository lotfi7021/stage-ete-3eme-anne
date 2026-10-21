<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Politique de sécurité du contenu.
     *
     * Le thème et AdminLTE utilisent des scripts/styles inline (handlers onclick,
     * scripts embarqués) : `unsafe-inline`/`unsafe-eval` restent nécessaires.
     * Les domaines Google couvrent les polices et, le cas échéant, reCAPTCHA.
     */
    private const CSP = "default-src 'self'; "
        . "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.google.com https://www.gstatic.com; "
        . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
        . "font-src 'self' data: https://fonts.gstatic.com; "
        . "img-src 'self' data: https:; "
        . "connect-src 'self'; "
        . "frame-src 'self' https://www.google.com; "
        . "frame-ancestors 'self'; "
        . "base-uri 'self'; "
        . "form-action 'self'; "
        . "object-src 'none'";

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        $response->headers->set('Content-Security-Policy', self::CSP);

        // HSTS : uniquement lorsque la réponse est servie en HTTPS.
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
