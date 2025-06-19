<?php
/**
 * flatten.php - Auto-discovery version
 * 
 * Automatically discovers all .php files in /views and creates routes
 * Convention: filename becomes route (home.php -> /, about.php -> /about)
 */

$distDir = __DIR__ . '/dist';
$viewsDir = __DIR__ . '/views';
$assetsSrc = __DIR__ . '/public/assets';
$assetsDest = $distDir . '/assets';

// Auto-discover routes from views directory
$routes = [];
$viewFiles = glob($viewsDir . '/*.php');

foreach ($viewFiles as $viewFile) {
    $filename = basename($viewFile, '.php');
    
    // Special case: home.php becomes root route
    if ($filename === 'home') {
        $routes['/'] = 'home';
    } else {
        $routes['/' . $filename] = $filename;
    }
}

echo "🔍 Auto-discovered routes:\n";
foreach ($routes as $uri => $view) {
    echo "  $uri -> views/$view.php\n";
}
echo "\n";

// Ensure dist exists
if (!is_dir($distDir)) {
    mkdir($distDir, 0777, true);
}

// Copy assets
if (is_dir($assetsSrc)) {
    if (!is_dir($assetsDest)) {
        mkdir($assetsDest, 0777, true);
    }
    $dir = opendir($assetsSrc);
    while (false !== ($file = readdir($dir))) {
        if ($file === '.' || $file === '..') continue;
        copy($assetsSrc . '/' . $file, $assetsDest . '/' . $file);
    }
    closedir($dir);
    echo "✓ Copied assets to /dist/assets\n";
}

// Generate navigation links automatically
function generateNavigation($currentUri, $routes) {
    $nav = [];
    
    foreach ($routes as $uri => $viewName) {
        $depth = $currentUri === '/' ? 0 : substr_count(trim($currentUri, '/'), '/') + 1;
        $relativePrefix = str_repeat('../', $depth);
        
        if ($uri === '/') {
            $link = $relativePrefix . 'index.html';
            $label = 'Home';
        } else {
            $slug = trim($uri, '/');
            $link = $relativePrefix . $slug . '/';
            $label = ucfirst($slug);
        }
        
        $nav[] = '<a href="' . $link . '" class="text-blue-600 hover:underline">' . $label . '</a>';
    }
    
    return implode(' | ', $nav);
}

foreach ($routes as $uri => $viewName) {
    // Capture body content
    ob_start();
    include __DIR__ . '/views/' . $viewName . '.php';
    $bodyContent = ob_get_clean();

    // Load header
    $headerPath = __DIR__ . '/partials/header.php';
    $headerContent = file_get_contents($headerPath);

    // Calculate relative paths
    if ($uri === '/') {
        $logoLink = 'index.html';
        $filePath = $distDir . '/index.html';
    } else {
        $slug = trim($uri, '/');
        $logoLink = '../index.html';
        
        $folder = $distDir . '/' . $slug;
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        $filePath = $folder . '/index.html';
    }

    // Auto-generate navigation
    $navigation = generateNavigation($uri, $routes);

    // Replace placeholders
    $headerContent = str_replace('{{LOGO_LINK}}', '<a href="' . $logoLink . '" class="font-bold">CANOE</a>', $headerContent);
    $headerContent = str_replace('{{NAVIGATION}}', $navigation, $headerContent);
    
    // Fallback for old template style
    if (strpos($headerContent, '{{ABOUT_LINK}}') !== false) {
        $depth = $uri === '/' ? 0 : 1;
        $aboutLink = str_repeat('../', $depth) . 'about/';
        $headerContent = str_replace('{{ABOUT_LINK}}', '<a href="' . $aboutLink . '" class="text-blue-600 hover:underline">About</a>', $headerContent);
    }

    $footerContent = file_get_contents(__DIR__ . '/partials/footer.php');

    // Write final HTML
    $output = $headerContent . $bodyContent . $footerContent;
    file_put_contents($filePath, $output);

    echo "✓ Built: $filePath\n";
}

echo "✔️ All pages auto-discovered and flattened!\n";
?>