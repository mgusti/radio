<?php
require_once __DIR__ . '/../config/Database.php';

try {
    $db = \Config\Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT * FROM settings WHERE setting_key = 'admin_slug'");
    $stmt->execute();
    $results = $stmt->fetchAll();
    echo "Found " . count($results) . " rows for admin_slug:\n";
    foreach ($results as $row) {
        echo "- Value: [" . $row['setting_value'] . "]\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
