<?php
/**
 * Bonsai Template System
 * Wrapper and layout functions
 */

function bonsai_wrap($content, $mode = '') {
    // Auto-detect markdown content
    $is_markdown = (strpos($content, '<h1>') !== false || 
                   strpos($content, '<h2>') !== false || 
                   strpos($content, '<p>') !== false);
    
    if ($is_markdown) {
        $content = "<div class='prose prose-lg max-w-none'>{$content}</div>";
    }
    
    switch ($mode) {
        case 'card':
            return bonsai_view('components/card', ['content' => $content]);
        case 'sidebar':
            return bonsai_view('components/sidebar', ['content' => $content]);
        case 'alert':
            return bonsai_view('components/alert', ['content' => $content, 'type' => 'info']);
        default:
            return $content;
    }
}

// Legacy wrapper function for backward compatibility
function wrap($content, $mode = '') {
    return bonsai_wrap($content, $mode);
}