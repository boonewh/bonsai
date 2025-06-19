<?php

require_once 'Parsedown.php';

function wrap_card($content) {
    return "<div class='bg-white shadow p-6 rounded-lg'>{$content}</div>";
}

function wrap_sidebar($content) {
    return "
    <div class='flex flex-col md:flex-row gap-6'>
        <aside class='w-full md:w-1/4 text-sm text-gray-600 bg-gray-50 p-4 rounded'>
            <p class='font-semibold mb-2'>Sidebar</p>
            <ul class='space-y-1 text-blue-600 underline'>
                <li><a href='/home'>Home</a></li>
                <li><a href='/about'>About</a></li>
            </ul>
        </aside>
        <section class='w-full md:w-3/4'>
            {$content}
        </section>
    </div>";
}

function wrap_alert($content, $type = 'info') {
    $classes = [
        'info' => 'bg-blue-100 border-blue-500 text-blue-700',
        'warning' => 'bg-yellow-100 border-yellow-500 text-yellow-700',
        'error' => 'bg-red-100 border-red-500 text-red-700',
        'success' => 'bg-green-100 border-green-500 text-green-700',
    ];

    $style = $classes[$type] ?? $classes['info'];

    return "<div class='border-l-4 p-4 mb-4 {$style}'>{$content}</div>";
}

function wrap($content, $mode = '') {
    // Auto-detect if content looks like markdown output
    $is_markdown = (strpos($content, '<h1>') !== false || strpos($content, '<h2>') !== false || strpos($content, '<p>') !== false);
    
    if ($is_markdown) {
        $content = "<div class='prose prose-lg max-w-none'>{$content}</div>";
    }
    
    switch ($mode) {
        case 'card':
            return wrap_card($content);
        case 'sidebar':
            return wrap_sidebar($content);
        default:
            return $content;
    }
}

// NEW MARKDOWN FUNCTIONS

function markdown($text) {
    $parsedown = new Parsedown();
    return $parsedown->text($text);
}

function markdown_file($path, $excerpt_length = null) {
    if (!file_exists($path)) {
        return "<p class='text-red-500'>Markdown file not found: {$path}</p>";
    }
    
    $content = file_get_contents($path);
    
    if ($excerpt_length) {
        $content = substr($content, 0, $excerpt_length);
    }
    
    $parsedown = new Parsedown();
    return $parsedown->text($content);
}

function parse_markdown_page($filepath) {
    $content = file_get_contents($filepath);
    
    // Check for frontmatter
    if (strpos($content, '---') === 0) {
        $parts = explode('---', $content, 3);
        $frontmatter = trim($parts[1]);
        $markdown_content = trim($parts[2]);
        
        // Parse frontmatter (simple YAML-like parsing)
        $metadata = [];
        $lines = explode("\n", $frontmatter);
        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                list($key, $value) = explode(':', $line, 2);
                $metadata[trim($key)] = trim($value);
            }
        }
        
        $parsedown = new Parsedown();
        $html_content = $parsedown->text($markdown_content);
        
        return [
            'metadata' => $metadata,
            'content' => $html_content
        ];
    } else {
        // No frontmatter, just markdown
        $parsedown = new Parsedown();
        return [
            'metadata' => [],
            'content' => $parsedown->text($content)
        ];
    }
}