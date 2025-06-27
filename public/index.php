<?php
/**
 * Bonsai Framework Entry Point
 * Now cleaner and more organized
 */

require_once '../bonsai/router.php';

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Load the page
$page_data = bonsai_load_page($uri);

// Extract data
extract($page_data);

// Render with or without layout
if ($use_layout ?? true) {
    $layout = $layout ?? bonsai_config('layout.default', 'app');
    include "../templates/layouts/{$layout}.php";
} else {
    include '../templates/partials/header.php';
    echo $content;
    include '../templates/partials/footer.php';
}