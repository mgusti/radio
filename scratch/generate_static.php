<?php
// Mock server variables for home page
$_SERVER['REQUEST_URI'] = '/radio/';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['SCRIPT_NAME'] = '/radio/public/index.php';

// Capture output
ob_start();
require __DIR__ . '/../public/index.php';
$html = ob_get_clean();

// Fix asset paths for GitHub Pages (relative paths)
// The original code uses $baseUrl which is dynamic.
// For static export, we want paths to be relative to the folder.
$html = str_replace('/radio/public/css/', 'css/', $html);
$html = str_replace('/radio/public/js/', 'js/', $html);
$html = str_replace('/radio/public/', '', $html);

// Save to gibelfm/index.html
file_put_contents(__DIR__ . '/../gibelfm/index.html', $html);

echo "Static HTML generated in gibelfm/index.html\n";
