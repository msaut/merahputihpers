<?php

return [
    'positions' => [
        'header' => [
            'label' => 'Header',
            'width' => 970,
            'height' => 250,
            'max_size_kb' => 2048,
            'ratio' => '3.88:1',
            'description' => 'Banner besar di bagian atas konten.',
        ],
        'leaderboard' => [
            'label' => 'Leaderboard',
            'width' => 728,
            'height' => 90,
            'max_size_kb' => 2048,
            'ratio' => '8.09:1',
            'description' => 'Banner horizontal untuk desktop.',
        ],
        'sidebar' => [
            'label' => 'Sidebar',
            'width' => 300,
            'height' => 250,
            'max_size_kb' => 2048,
            'ratio' => '1:0.83',
            'description' => 'Banner untuk sidebar kanan/kiri.',
        ],
        'mobile' => [
            'label' => 'Mobile',
            'width' => 320,
            'height' => 100,
            'max_size_kb' => 1024,
            'ratio' => '3.2:1',
            'description' => 'Banner untuk tampilan smartphone.',
        ],
        'square' => [
            'label' => 'Square',
            'width' => 300,
            'height' => 300,
            'max_size_kb' => 2048,
            'ratio' => '1:1',
            'description' => 'Banner kotak untuk promosi.',
        ],
    ],
    'default_validation_mode' => 'recommended',
    'allowed_mimes' => ['jpeg', 'png', 'webp'],
    'allowed_targets' => ['_self', '_blank'],
];
