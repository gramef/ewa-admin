<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandlePrivateNetworkAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Delegate full CORS handling to Laravel's HandleCors middleware.
        $response = $next($request);

        // For preflight requests that ask for private network access, append the required header.
        if ($request->isMethod('OPTIONS') && $request->headers->has('Access-Control-Request-Private-Network')) {
            $response->headers->set('Access-Control-Allow-Private-Network', 'true');

            // Ensure caches vary on this request header
            $existingVary = $response->headers->get('Vary');
            $response->headers->set(
                'Vary',
                $existingVary ? $existingVary . ', Access-Control-Request-Private-Network' : 'Access-Control-Request-Private-Network'
            );
        }

        return $response;
    }
}