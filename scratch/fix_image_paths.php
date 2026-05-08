<?php

require_once __DIR__ . '/../config/database.php';
use Config\Database;

try {
    $db = Database::getInstance()->getConnection();
    
    // Fix the image paths for the dummy news
    $stmt = $db->prepare("UPDATE news SET image_url = CONCAT('/radio/public/', image_url) WHERE id IN (5, 6, 7, 8) AND image_url NOT LIKE '/radio/public/%'");
    $stmt->execute();
    
    echo "Image paths updated successfully.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
