<?php

namespace App\Models;

class Setting extends Model {
    protected $table = 'settings';

    public function get($key, $default = null) {
        $stmt = $this->db->prepare("SELECT setting_value FROM {$this->table} WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();
        return $result ? $result['setting_value'] : $default;
    }

    public function set($key, $value) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
        return $stmt->execute([$key, $value, $value]);
    }
}
