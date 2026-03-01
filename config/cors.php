<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    // Explicitly list local dev origins; add more if needed (e.g., vendor web app port)
    'allowed_origins' => [
        // Flutter web dev servers in this session
        'http://localhost:58061',
        'http://127.0.0.1:58061',
        'http://localhost:58059',
        'http://127.0.0.1:58059',
        'http://localhost:8002',
        'http://127.0.0.1:8002',
        'http://localhost:8003',
        'http://127.0.0.1:8003',
        'http://localhost:8010',
        'http://127.0.0.1:8010',
        // Added consumer web dev server
        'http://localhost:8013',
        'http://127.0.0.1:8013',
        // Added vendor web dev server
        'http://localhost:8014',
        'http://127.0.0.1:8014',
        // Flutter web-server current ports
        'http://localhost:5173',
        'http://127.0.0.1:5173',
        'http://localhost:5174',
        'http://127.0.0.1:5174',
        // Flutter web-server port 8081
        'http://localhost:8081',
        'http://127.0.0.1:8081',
        // Flutter web-server (dynamic) preview port used in this session
        'http://localhost:53533',
        'http://127.0.0.1:53533',
        // Flutter build/web static server
        'http://localhost:5180',
        'http://127.0.0.1:5180',
        // Optional additional port sometimes used
        'http://localhost:5182',
        'http://127.0.0.1:5182',
        // Added client app port for Flutter web on 3000
        'http://localhost:3000',
        'http://127.0.0.1:3000',
        // Herd local domain serving Laravel
        'http://ewa-admin-php.test',
        // ── Vercel Production PWAs ──
        'https://ewa-client-pwa.vercel.app',
        'https://ewa-vendor-pwa.vercel.app',
    ],

    'allowed_origins_patterns' => [],

    // Do NOT include Access-Control-* headers here; browsers set and validate these
    'allowed_headers' => ['*'],

    // Expose Authorization if your frontend needs to read it
    'exposed_headers' => ['Authorization'],

    'max_age' => 86400,

    // Keep false unless you need cookies/Authorization headers with credentials
    'supports_credentials' => true,

];
