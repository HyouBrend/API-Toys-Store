<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf'          => \CodeIgniter\Filters\CSRF::class,
        'toolbar'       => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot'      => \CodeIgniter\Filters\Honeypot::class,
        'invalidchars'  => \CodeIgniter\Filters\InvalidChars::class,
        'secureheaders' => \CodeIgniter\Filters\SecureHeaders::class,
        'cors'          => \App\Filters\CorsFilter::class, // Alias untuk CORS filter
    ];

    public array $globals = [
        'before' => [
            'cors', // Pastikan filter CORS aktif di sini
        ],
        'after' => [
            'cors' => ['except' => ['api/*']], // Terapkan untuk rute tertentu
        ],
    ];

    public array $methods = [];
    public array $filters = [];
}