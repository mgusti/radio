<?php
// Mock server variables for home page
$_SERVER['REQUEST_URI'] = '/radio/';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['SCRIPT_NAME'] = '/radio/public/index.php';

// Capture output
ob_start();
require __DIR__ . '/../public/index.php';
$html = ob_get_clean();

// Fix asset paths for static export
$html = str_replace('/radio/public/css/', 'css/', $html);
$html = str_replace('/radio/public/js/', 'js/', $html);
$html = str_replace('/radio/public/img/', 'img/', $html);
// General fallback for any other public assets
$html = str_replace('/radio/public/', '', $html);

// Fix links to be relative or pointing to landing
$html = str_replace('href="/radio/news"', 'href="#news"', $html);

// Save to gibelfm/index.html
if (!is_dir(__DIR__ . '/../gibelfm')) {
    mkdir(__DIR__ . '/../gibelfm', 0777, true);
}
file_put_contents(__DIR__ . '/../gibelfm/index.html', $html);

// Helper function to sync assets
function sync_dir($src, $dst) {
    if (!is_dir($dst)) mkdir($dst, 0777, true);
    $files = scandir($src);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        if (is_dir("$src/$file")) {
            sync_dir("$src/$file", "$dst/$file");
        } else {
            copy("$src/$file", "$dst/$file");
        }
    }
}

// Update assets
sync_dir(__DIR__ . '/../public/css', __DIR__ . '/../gibelfm/css');
sync_dir(__DIR__ . '/../public/js', __DIR__ . '/../gibelfm/js');
sync_dir(__DIR__ . '/../public/img', __DIR__ . '/../gibelfm/img');

echo "Static version updated successfully in gibelfm/ folder.\n";
echo "Main entry: gibelfm/index.html\n";
