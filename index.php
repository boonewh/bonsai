<?php
require_once 'inc/functions.php';

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$page = $uri ?: 'home';

$php_file = __DIR__ . "/pages/$page.php";
$md_file = __DIR__ . "/pages/$page.md";

// Check for PHP file first, then markdown
if (file_exists($php_file)) {
    // Existing PHP logic
    ob_start();
    include($php_file);
    $page_content = ob_get_clean();

    if (isset($use_layout) && $use_layout === true) {
        include('inc/layout.php');
    } else {
        include('inc/header.php');
        echo $page_content;
        include('inc/footer.php');
    }
} elseif (file_exists($md_file)) {
    // Handle markdown file
    $parsed = parse_markdown_page($md_file);
    
    // Set variables from frontmatter
    $title = $parsed['metadata']['title'] ?? ucfirst($page);
    $description = $parsed['metadata']['description'] ?? '';
    $wrap_mode = $parsed['metadata']['wrap_mode'] ?? '';
    $body_class = $parsed['metadata']['body_class'] ?? 'bg-gray-100 text-gray-900';
    
    // Set content for layout
    $content = $parsed['content'];
    $use_layout = true; // Markdown pages always use layout
    
    include('inc/layout.php');
} else {
    // 404 - neither PHP nor markdown file found
    http_response_code(404);
    include('inc/header.php');
    echo "<h1 class='text-3xl font-bold'>404 - Page Not Found</h1>";
    include('inc/footer.php');
}

