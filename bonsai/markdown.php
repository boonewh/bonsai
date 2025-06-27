<?php
/**
 * Bonsai Markdown Processing
 * Wrapper around Parsedown with frontmatter support
 */

require_once 'Parsedown.php';

function bonsai_markdown($text) {
    $parsedown = new Parsedown();
    return $parsedown->text($text);
}

function bonsai_markdown_file($path, $excerpt_length = null) {
    if (!file_exists($path)) {
        return "<p class='text-red-500'>Markdown file not found: {$path}</p>";
    }
    
    $content = file_get_contents($path);
    
    if ($excerpt_length) {
        $content = substr($content, 0, $excerpt_length);
    }
    
    return bonsai_markdown($content);
}

function bonsai_parse_markdown_page($filepath) {
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
        
        return [
            'metadata' => $metadata,
            'content' => bonsai_markdown($markdown_content)
        ];
    } else {
        // No frontmatter, just markdown
        return [
            'metadata' => [],
            'content' => bonsai_markdown($content)
        ];
    }
}

// Legacy functions for backward compatibility
function markdown($text) {
    return bonsai_markdown($text);
}

function markdown_file($path, $excerpt_length = null) {
    return bonsai_markdown_file($path, $excerpt_length);
}

function parse_markdown_page($filepath) {
    return bonsai_parse_markdown_page($filepath);
}