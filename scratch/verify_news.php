<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/Model.php';
require_once __DIR__ . '/../app/Models/News.php';

use App\Models\News;

try {
    $newsModel = new News();
    $allNews = $newsModel->all();
    
    echo "Current News in Database:\n";
    foreach ($allNews as $news) {
        echo "ID: {$news['id']} | Title: {$news['title']} | Author: {$news['author']} | Image: {$news['image_url']}\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
