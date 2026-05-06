<?php
require_once __DIR__ . '/../config/Database.php';

try {
    $db = \Config\Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'admin_slug'");
    $stmt->execute();
    $result = $stmt->fetch();
    if ($result) {
        $slug = $result['setting_value'];
        echo "Slug: [" . $slug . "]\n";
        echo "Length: " . strlen($slug) . "\n";
        for ($i = 0; $i < strlen($slug); $i++) {
            echo "Char $i: " . ord($slug[$i]) . " (" . $slug[$i] . ")\n";
        }
    } else {
        echo "No slug found in DB.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
