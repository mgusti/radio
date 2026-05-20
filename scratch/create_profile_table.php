<?php

require_once __DIR__ . '/../config/database.php';
use Config\Database;

try {
    $db = Database::getInstance()->getConnection();
    
    // 1. Create table
    $sql = "CREATE TABLE IF NOT EXISTS `profile` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `station_name` VARCHAR(255) NOT NULL,
        `tagline` VARCHAR(255) NOT NULL,
        `description` TEXT NOT NULL,
        `vision` TEXT NOT NULL,
        `missions` TEXT NOT NULL,
        `crew` TEXT NOT NULL,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $db->exec($sql);
    echo "Table 'profile' created or already exists.\n";
    
    // 2. Fetch existing profile settings from 'settings' table if any
    $stmt = $db->query("SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'profile_%'");
    $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    
    $station_name = $settings['profile_station_name'] ?? 'GibelFm';
    $tagline = $settings['profile_tagline'] ?? 'The Spirit of Muaro Jambi';
    $description = $settings['profile_description'] ?? 'GibelFm adalah radio komunitas terkemuka di Muaro Jambi yang menyajikan informasi terkini, edukasi, hiburan, dan kebudayaan lokal secara interaktif dan dinamis untuk memajukan daerah.';
    $vision = $settings['profile_vision'] ?? 'Menjadi media penyiaran komunitas terdepan dalam membangun masyarakat Muaro Jambi yang informatif, edukatif, dan berbudaya.';
    
    $defaultMissions = [
        'Menyajikan berita dan informasi lokal yang akurat, berimbang, dan tepercaya.',
        'Menyediakan program edukasi dan hiburan yang sehat serta membangun kreativitas lokal.',
        'Melestarikan seni, budaya, dan kearifan lokal Muaro Jambi.',
        'Menjadi wadah aspirasi dan interaksi sosial masyarakat secara inklusif.'
    ];
    $missions = isset($settings['profile_missions']) ? $settings['profile_missions'] : json_encode($defaultMissions, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    
    $defaultCrew = [
        [
            'name' => 'Junaedi (Djun)',
            'role' => 'Station Manager & Founder',
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=400',
            'social' => ['instagram' => 'https://www.instagram.com/radiogibelfmnews/', 'facebook' => 'https://www.facebook.com/gibelfm/']
        ],
        [
            'name' => 'Sarah Amelia',
            'role' => 'Program Director & Announcer',
            'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=400',
            'social' => ['instagram' => 'https://www.instagram.com/radiogibelfmnews/', 'tiktok' => 'https://www.tiktok.com/@djun_23']
        ],
        [
            'name' => 'Rian Hidayat',
            'role' => 'Technical Coordinator',
            'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=400',
            'social' => ['instagram' => 'https://www.instagram.com/radiogibelfmnews/', 'facebook' => 'https://www.facebook.com/gibelfm/']
        ]
    ];
    $crew = isset($settings['profile_crew']) ? $settings['profile_crew'] : json_encode($defaultCrew, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    
    // Check if a row already exists in profile
    $count = $db->query("SELECT COUNT(*) FROM `profile`")->fetchColumn();
    if ($count == 0) {
        $insert = $db->prepare("INSERT INTO `profile` (id, station_name, tagline, description, vision, missions, crew) VALUES (1, ?, ?, ?, ?, ?, ?)");
        $insert->execute([$station_name, $tagline, $description, $vision, $missions, $crew]);
        echo "Profile data populated successfully in 'profile' table.\n";
    } else {
        // Sync/update row 1 with current settings values just in case
        $update = $db->prepare("UPDATE `profile` SET station_name = ?, tagline = ?, description = ?, vision = ?, missions = ?, crew = ? WHERE id = 1");
        $update->execute([$station_name, $tagline, $description, $vision, $missions, $crew]);
        echo "Profile table already populated. Row 1 has been updated/synced with settings.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
