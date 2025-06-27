<?php
/**
 * Bonsai Framework Core
 * Simple functions for routing, templating, and configuration
 */

// Load configuration
function bonsai_config($key = null, $default = null) {
    static $config = null;
    
    if ($config === null) {
        $config = [];
        if (file_exists(__DIR__ . '/../config/site.php')) {
            $config = array_merge($config, require __DIR__ . '/../config/site.php');
        }
    }
    
    if ($key === null) return $config;
    
    return $config[$key] ?? $default;
}

// Simple routing
function bonsai_route($uri) {
    $page = trim($uri, '/') ?: 'home';
    
    // Check custom routes first
    $routes = bonsai_config('routes', []);
    if (isset($routes[$uri])) {
        $page = $routes[$uri];
    }
    
    return $page;
}

// Template rendering
function bonsai_view($template, $data = []) {
    extract($data);
    
    $template_path = __DIR__ . "/../templates/{$template}.php";
    if (file_exists($template_path)) {
        ob_start();
        include $template_path;
        return ob_get_clean();
    }
    
    return "<p>Template not found: {$template}</p>";
}

// Asset URL helper
function bonsai_asset($path) {
    $base = bonsai_config('base_url', '');
    return rtrim($base, '/') . '/assets/' . ltrim($path, '/');
}

// URL helper
function bonsai_url($path = '') {
    $base = bonsai_config('base_url', '');
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}