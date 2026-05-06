<?php

namespace App\Controllers;

use App\Models\News;

class NewsController {
    public function index() {
        $newsModel = new News();
        
        $limit = 6;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
        
        $totalItems = $newsModel->countAll();
        $totalPages = ceil($totalItems / $limit);
        $newsItems = $newsModel->paginate($limit, $offset);

        view('news', [
            'title' => 'Latest News - GibelFm',
            'newsItems' => $newsItems,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function show() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /radio/news');
            exit;
        }

        $newsModel = new News();
        $news = $newsModel->find($id);

        if (!$news) {
            header('Location: /radio/news');
            exit;
        }

        view('news_detail', [
            'title' => $news['title'] . ' - GibelFm',
            'news' => $news
        ]);
    }
}
