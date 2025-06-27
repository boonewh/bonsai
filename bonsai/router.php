<?php
/**
 * Bonsai Router
 * Handles page discovery and loading
 */

require_once 'core.php';
require_once 'template.php';
require_once 'markdown.php';

function bonsai_load_page($uri) {
    $page = bonsai_route($uri);
    
    $php_file = __DIR__ . "/../pages/{$page}.php";
    $md_file = __DIR__ . "/../pages/{$page}.md";
    $content_md = __DIR__ . "/../content/{$page}.md";
    
    // Try PHP file first
    if (file_exists($php_file)) {
        return bonsai_load_php_page($php_file);
    }
    
    // Try markdown in pages
    if (file_exists($md_file)) {
        return bonsai_load_markdown_page($md_file);
    }
    
    // Try markdown in content
    if (file_exists($content_md)) {
        return bonsai_load_markdown_page($content_md);
    }
    
    // 404
    http_response_code(404);
    return [
        'use_layout' => true,
        'title' => '404 - Page Not Found',
        'content' => '<h1 class="text-3xl font-bold text-red-600">404 - Page Not Found</h1><p>The page you are looking for does not exist.</p>'
    ];
}

function bonsai_load_php_page($file) {
    ob_start();
    include $file;
    $content = ob_get_clean();
    
    // Return data based on whether layout is used
    if (isset($use_layout) && $use_layout === true) {
        return compact('use_layout', 'title', 'description', 'wrap_mode', 'body_class', 'content');
    } else {
        return ['use_layout' => false, 'content' => $content];
    }
}

function bonsai_load_markdown_page($file) {
    $parsed = bonsai_parse_markdown_page($file);
    
    return [
        'use_layout' => true,
        'title' => $parsed['metadata']['title'] ?? ucfirst(basename($file, '.md')),
        'description' => $parsed['metadata']['description'] ?? '',
        'wrap_mode' => $parsed['metadata']['wrap_mode'] ?? '',
        'body_class' => $parsed['metadata']['body_class'] ?? 'bg-gray-100 text-gray-900',
        'content' => $parsed['content']
    ];
}