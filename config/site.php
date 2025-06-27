<?php
return [
    'name' => 'Bonsai Framework',
    'description' => 'A lightweight, modern PHP site kit.',
    'base_url' => '', // Set this for subdirectory installs
    
    // Custom routes (optional)
    'routes' => [
        // '/custom-url' => 'page-name',
    ],
    
    // Default layout settings
    'layout' => [
        'default' => 'app',
        'wrap_mode' => '',
        'body_class' => 'bg-gray-100 text-gray-900'
    ],
    
    // Navigation (for auto-generation)
    'nav' => [
        'Home' => '/',
        'About' => '/about',
    ]
];