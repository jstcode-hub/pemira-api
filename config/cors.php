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
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Izinkan semua metode HTTP
    'allowed_methods' => ['*'],

    // Tambahkan semua domain frontend yang terhubung
    'allowed_origins' => [
        'https://pemira.sandboxdevlab.com',
        'https://pemira-zeta.vercel.app',  // If you still want to allow this origin
    ],

    'allowed_origins_patterns' => [],

    // Izinkan semua header atau tentukan secara spesifik
    'allowed_headers' => ['*'],

    // Header yang dapat diekspos ke frontend
    'exposed_headers' => ['X-XSRF-TOKEN'],

    'max_age' => 0,

    // Perlu diaktifkan jika Anda menggunakan cookies atau otentikasi berbasis sesi
    'supports_credentials' => true,
];
