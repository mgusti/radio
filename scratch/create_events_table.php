<?php

require_once __DIR__ . '/../config/database.php';
use Config\Database;

try {
    $db = Database::getInstance()->getConnection();
    
    $sql = "CREATE TABLE IF NOT EXISTS events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        type ENUM('program', 'event') NOT NULL,
        event_date DATE NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $db->exec($sql);
    echo "Table 'events' created successfully.\n";

    // Insert dummy data if empty
    $count = $db->query("SELECT COUNT(*) FROM events")->fetchColumn();
    if ($count == 0) {
        $dummyEvents = [
            ['Morning Talk Show', 'program', '2026-05-10', 'Our signature morning talk show.'],
            ['Music Festival', 'event', '2026-05-15', 'Annual summer music festival.'],
            ['DJ Spark Interview', 'program', '2026-05-20', 'Exclusive interview with DJ Spark.'],
            ['Community Clean-up', 'event', '2026-05-25', 'Joining hands for a cleaner city.'],
        ];

        $stmt = $db->prepare("INSERT INTO events (title, type, event_date, description) VALUES (?, ?, ?, ?)");
        foreach ($dummyEvents as $event) {
            $stmt->execute($event);
        }
        echo "Dummy events inserted.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
