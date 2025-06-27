<?php
/**
 * Bonsai Static Site Builder
 * Generates flat HTML files for static hosting
 */

require_once 'bonsai/core.php';
require_once 'bonsai/router.php';

class BonsaiBuilder {
    private $distDir;
    private $pages = [];
    
    public function __construct() {
        $this->distDir = __DIR__ . '/dist';
        $this->discoverPages();
    }
    
    public function build() {
        $this->createDistDirectory();
        $this->copyAssets();
        $this->generatePages();
        echo "✅ Static site built successfully in /dist/\n";
    }
    
    private function discoverPages() {
        // Discover PHP pages
        $phpPages = glob(__DIR__ . '/pages/*.php');
        foreach ($phpPages as $file) {
            $name = basename($file, '.php');
            $this->pages[] = ['name' => $name, 'uri' => $name === 'home' ? '' : $name];
        }
        
        // Discover Markdown pages
        $mdPages = glob(__DIR__ . '/pages/*.md');
        foreach ($mdPages as $file) {
            $name = basename($file, '.md');
            $this->pages[] = ['name' => $name, 'uri' => $name];
        }
        
        echo "🔍 Discovered pages:\n";
        foreach ($this->pages as $page) {
            $uri = $page['uri'] ?: '/';
            echo "  /{$uri} -> {$page['name']}\n";
        }
        echo "\n";
    }
    
    private function generatePages() {
        foreach ($this->pages as $page) {
            $uri = $page['uri'];
            $page_data = bonsai_load_page($uri);
            
            // Render the page
            ob_start();
            extract($page_data);
            $layout = $layout ?? 'app';
            include "templates/layouts/{$layout}.php";
            $html = ob_get_clean();
            
            // Determine output path
            if ($uri === '' || $uri === 'home') {
                $outputPath = $this->distDir . '/index.html';
            } else {
                $dir = $this->distDir . '/' . $uri;
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                $outputPath = $dir . '/index.html';
            }
            
            file_put_contents($outputPath, $html);
            echo "✓ Built: {$outputPath}\n";
        }
    }
    
    private function createDistDirectory() {
        if (!is_dir($this->distDir)) {
            mkdir($this->distDir, 0777, true);
        }
    }
    
    private function copyAssets() {
        $assetsSrc = __DIR__ . '/public/assets';
        $assetsDest = $this->distDir . '/assets';
        
        if (is_dir($assetsSrc)) {
            $this->recursiveCopy($assetsSrc, $assetsDest);
            echo "✓ Copied assets to /dist/assets\n";
        }
    }
    
    private function recursiveCopy($src, $dst) {
        if (!is_dir($dst)) {
            mkdir($dst, 0777, true);
        }
        
        $dir = opendir($src);
        while (false !== ($file = readdir($dir))) {
            if ($file != '.' && $file != '..') {
                $srcFile = $src . '/' . $file;
                $dstFile = $dst . '/' . $file;
                
                if (is_dir($srcFile)) {
                    $this->recursiveCopy($srcFile, $dstFile);
                } else {
                    copy($srcFile, $dstFile);
                }
            }
        }
        closedir($dir);
    }
    
    public static function generate() {
        $builder = new BonsaiBuilder();
        $builder->build();
    }
}

// Run the builder
BonsaiBuilder::generate();