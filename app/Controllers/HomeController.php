<?php

namespace App\Controllers;

use App\Models\News;

class HomeController {
    public function index() {
        $streamUrl = "https://pu.klikhost.com/proxy/radiogib/stream";
        
        $newsModel = new News();
        $latestNews = $newsModel->all(); // Or limit it in the model
        $latestNews = array_slice($latestNews, 0, 3); // Take latest 3

        // Pass data to view
        view('home', [
            'title' => 'Pemutar Radio - Siaran Langsung',
            'streamUrl' => $streamUrl,
            'latestNews' => $latestNews
        ]);
    }
}
