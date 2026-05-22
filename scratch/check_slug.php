<?php
require_once __DIR__ . '/../config/database.php';

try {
    $db = \Config\Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = 'admin_slug'");
    $stmt->execute();
    $result = $stmt->fetch();
    echo "Current ADMIN_SLUG in DB: " . ($result ? $result['setting_value'] : 'NOT SET (default: admin)') . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
