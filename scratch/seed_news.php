<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/Model.php';
require_once __DIR__ . '/../app/Models/News.php';

use Config\Database;
use App\Models\News;

try {
    $newsModel = new News();
    
    $dummyNews = [
        [
            'title' => 'Summer Music Festival 2026',
            'excerpt' => 'The biggest music event of the summer is coming to town this June.',
            'content' => 'Get ready for an unforgettable night with top DJs and live bands. The Summer Music Festival 2026 will feature a state-of-the-art sound system and mesmerizing light shows. Join thousands of music lovers for a night of pure energy and rhythm.',
            'image_url' => 'img/news1.png',
            'date' => date('Y-m-d'),
            'author' => 'Event Team'
        ],
        [
            'title' => 'Exclusive Interview: DJ Spark',
            'excerpt' => 'We sit down with DJ Spark to discuss his upcoming world tour and new album.',
            'content' => 'In this exclusive interview, DJ Spark shares his inspiration behind his latest hits and what fans can expect from his world tour. He also gives us a sneak peek into the recording process of his highly anticipated new album.',
            'image_url' => 'img/news2.png',
            'date' => date('Y-m-d'),
            'author' => 'Radio Host'
        ],
        [
            'title' => 'New Morning Show Launching Soon',
            'excerpt' => 'A fresh start to your mornings with our new "Sunrise Vibes" program.',
            'content' => 'Starting next Monday, "Sunrise Vibes" will bring you the best morning tunes, news updates, and traffic reports to kickstart your day. Tune in at 6 AM to join our new hosts for a fun and informative morning experience.',
            'image_url' => 'img/news3.png',
            'date' => date('Y-m-d'),
            'author' => 'Station Manager'
        ],
        [
            'title' => 'Community Park Clean-up Drive',
            'excerpt' => 'Join us this Saturday for a community clean-up drive at the City Central Park.',
            'content' => 'We are organizing a community effort to keep our city green and clean. Volunteers are welcome to join us this Saturday at 9 AM for the Central Park clean-up. Equipment will be provided. Let\'s work together for a better environment!',
            'image_url' => 'img/news4.png',
            'date' => date('Y-m-d'),
            'author' => 'Community News'
        ]
    ];

    foreach ($dummyNews as $news) {
        $result = $newsModel->create(
            $news['title'],
            $news['excerpt'],
            $news['content'],
            $news['image_url'],
            $news['date'],
            $news['author']
        );
        if ($result) {
            echo "Inserted: " . $news['title'] . "\n";
        } else {
            echo "Failed to insert: " . $news['title'] . "\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
