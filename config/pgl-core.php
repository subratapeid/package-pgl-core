<?php

return [
    'bootstrap_modules' => true,

    'routing' => [
        'admin_prefix' => 'admin',
        'storefront_prefix' => '',
        'api_prefix' => 'api',
        'api_version' => 'v1',
    ],

    'module_paths' => [
        base_path('packages'),
        base_path('vendor/pgl'),
    ],

    'themes' => [
        'areas' => [
            'admin' => [
                'active' => env('PGL_ADMIN_THEME', 'default'),
                'path' => base_path('themes/admin'),
            ],
            'storefront' => [
                'active' => env('PGL_STOREFRONT_THEME', 'default'),
                'path' => base_path('themes/storefront'),
            ],
        ],
    ],

    'media' => [
        'disk' => env('PGL_MEDIA_DISK', 'media'),
        'collection' => 'library',
        'max_upload_kb' => 10240,
    ],
];