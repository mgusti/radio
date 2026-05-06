<?php

namespace App\Controllers;

use App\Models\News;

class NewsController {
    public function index() {
        $newsModel = new News();
        $newsItems = $newsModel->all();

        view('news', [
            'title' => 'Latest News - GibelFm',
            'newsItems' => $newsItems
        ]);
    }
}
