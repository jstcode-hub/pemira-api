<?php

return [

    /*
    |----------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |----------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Menentukan path yang diizinkan untuk CORS

    'allowed_methods' => ['*'], // Mengizinkan semua metode HTTP (GET, POST, PUT, DELETE, OPTIONS)

    'allowed_origins' => [
        'https://pemira.sandboxdevlab.com', // Menambahkan subdomain frontend yang benar
        'https://pemira-zeta.vercel.app', // Menambahkan subdomain frontend lain jika diperlukan
        'http://localhost:3000', // Untuk pengembangan lokal
    ],

    'allowed_origins_patterns' => [], // Tidak ada pola khusus untuk origin yang diperbolehkan

    'allowed_headers' => ['*'], // Mengizinkan semua header (misalnya X-XSRF-TOKEN, Authorization)

    'exposed_headers' => ['X-XSRF-TOKEN'], // Mengekspos header X-XSRF-TOKEN untuk diakses oleh frontend

    'max_age' => 3600, // Durasi cache CORS dalam detik

    'supports_credentials' => true, // Mendukung pengiriman kredensial (cookies, Authorization header)

];
