<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Security Headers Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for security headers middleware.
    | Different environments can have different security policies.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Environment-based Configuration
    |--------------------------------------------------------------------------
    |
    | Configure different security policies based on environment
    |
    */
    'environments' => [
        'local' => [
            'csp_report_only' => true,
            'strict_transport_security' => false,
        ],
        'staging' => [
            'csp_report_only' => true,
            'strict_transport_security' => true,
        ],
        'production' => [
            'csp_report_only' => true,
            'strict_transport_security' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP Strict Transport Security (HSTS)
    |--------------------------------------------------------------------------
    |
    | HSTS header configuration
    |
    */
    'hsts' => [
        'max_age' => 31536000, // 1 year
        'include_subdomains' => true,
        'preload' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Content Security Policy (CSP)
    |--------------------------------------------------------------------------
    |
    | CSP configuration compatible with Vite and Livewire
    |
    */
    'csp' => [
        'default-src' => ["'self'"],
        'script-src' => [
            "'self'",
            // Vite dev server for local development
            env('APP_ENV') === 'local' ? 'http://localhost:5173' : null,
            // Nonce will be added dynamically
        ],
        'style-src' => [
            "'self'",
            "'unsafe-inline'", // Required for Tailwind CSS and some dynamic styles
            env('APP_ENV') === 'local' ? 'http://localhost:5173' : null,
        ],
        'img-src' => [
            "'self'",
            'data:',
            'blob:',
            // Cloudflare R2 storage
            'https://fls-9f7b5f3d-44c0-4ed9-aa5f-91509293c572.laravel.cloud',
            'https://367be3a2035528943240074d0096e0cd.r2.cloudflarestorage.com',
        ],
        'font-src' => [
            "'self'",
            'data:',
        ],
        'connect-src' => [
            "'self'",
            // Livewire endpoints
            env('APP_URL', 'http://localhost'),
            // Reverb WebSocket
            env('REVERB_SCHEME', 'http') . '://' . env('REVERB_HOST', 'localhost') . ':' . env('REVERB_PORT', '8080'),
            // Vite dev server for local development
            env('APP_ENV') === 'local' ? 'ws://localhost:5173' : null,
            env('APP_ENV') === 'local' ? 'http://localhost:5173' : null,
        ],
        'frame-src' => [
            "'none'",
        ],
        'object-src' => [
            "'none'",
        ],
        'base-uri' => [
            "'self'",
        ],
        'form-action' => [
            "'self'",
        ],
        'frame-ancestors' => [
            "'none'",
        ],
        'upgrade-insecure-requests' => env('APP_ENV') !== 'local',
    ],

    /*
    |--------------------------------------------------------------------------
    | X-Content-Type-Options
    |--------------------------------------------------------------------------
    |
    | Prevents MIME type sniffing
    |
    */
    'content_type_options' => 'nosniff',

    /*
    |--------------------------------------------------------------------------
    | X-Frame-Options
    |--------------------------------------------------------------------------
    |
    | Controls whether the page can be displayed in a frame
    |
    */
    'frame_options' => 'DENY',

    /*
    |--------------------------------------------------------------------------
    | Referrer Policy
    |--------------------------------------------------------------------------
    |
    | Controls how much referrer information is included with requests
    |
    */
    'referrer_policy' => 'strict-origin-when-cross-origin',

    /*
    |--------------------------------------------------------------------------
    | Permissions Policy
    |--------------------------------------------------------------------------
    |
    | Controls which browser features can be used
    |
    */
    'permissions_policy' => [
        'camera' => [],
        'microphone' => [],
        'geolocation' => [],
        'interest-cohort' => [], // Disable FLoC
        'payment' => [],
        'usb' => [],
        'vr' => [],
        'xr-spatial-tracking' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | X-Permitted-Cross-Domain-Policies
    |--------------------------------------------------------------------------
    |
    | Controls cross-domain policies for Adobe Flash and PDF files
    |
    */
    'cross_domain_policies' => 'none',

    /*
    |--------------------------------------------------------------------------
    | CSP Report URI
    |--------------------------------------------------------------------------
    |
    | URI where CSP violation reports should be sent
    |
    */
    'csp_report_uri' => env('CSP_REPORT_URI'),

    /*
    |--------------------------------------------------------------------------
    | Additional Headers
    |--------------------------------------------------------------------------
    |
    | Any additional custom headers
    |
    */
    'additional_headers' => [
        'X-XSS-Protection' => '1; mode=block',
        'X-Download-Options' => 'noopen',
        'X-DNS-Prefetch-Control' => 'off',
    ],
];
