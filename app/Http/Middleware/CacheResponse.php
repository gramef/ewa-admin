<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class CacheResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  int  $minutes
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $minutes = 60)
    {
        // Only cache GET requests
        if ($request->method() !== 'GET') {
            return $next($request);
        }

        // Don't cache authenticated user-specific data
        $cacheKey = $this->getCacheKey($request);
        
        // Check if response is cached
        if (Cache::has($cacheKey)) {
            $cachedResponse = Cache::get($cacheKey);
            return response($cachedResponse['content'], $cachedResponse['status'])
                ->withHeaders($cachedResponse['headers'])
                ->header('X-Cache', 'HIT');
        }

        // Get fresh response
        $response = $next($request);

        // Only cache successful responses
        if ($response->getStatusCode() === 200) {
            $cacheData = [
                'content' => $response->getContent(),
                'status' => $response->getStatusCode(),
                'headers' => $this->getHeadersToCache($response)
            ];

            Cache::put($cacheKey, $cacheData, now()->addMinutes($minutes));
            $response->header('X-Cache', 'MISS');
        }

        return $response;
    }

    /**
     * Generate cache key for the request
     */
    private function getCacheKey(Request $request): string
    {
        $key = 'api_cache:' . md5($request->fullUrl());
        
        // Include user ID for user-specific data
        if (Auth::check()) {
            $key .= ':user_' . Auth::id();
        }

        return $key;
    }

    /**
     * Get headers that should be cached
     */
    private function getHeadersToCache($response): array
    {
        $headers = $response->headers->all();
        
        // Only cache specific headers
        $allowedHeaders = [
            'content-type',
            'content-encoding',
            'cache-control'
        ];

        return array_intersect_key($headers, array_flip($allowedHeaders));
    }
}
