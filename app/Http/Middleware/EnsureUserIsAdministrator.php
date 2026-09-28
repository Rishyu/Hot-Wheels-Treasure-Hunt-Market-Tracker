<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdministrator
{
    /**
     * Restrict administrative routes to administrator accounts.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Administrative functionality must not be available to collectors.
        if (! $user || ! $user->isAdministrator()) {
            abort(403);
        }

        return $next($request);
    }
}