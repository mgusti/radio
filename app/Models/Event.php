<?php

namespace App\Models;

class Event extends Model {
    protected $table = 'events';

    public function latest() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY event_date DESC LIMIT 1");
        return $stmt->fetch();
    }

    public function current() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE event_date = ? ORDER BY id ASC LIMIT 1");
        $stmt->execute([date('Y-m-d')]);
        return $stmt->fetch();
    }

    public function upcoming() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE event_date > ? ORDER BY event_date ASC LIMIT 1");
        $stmt->execute([date('Y-m-d')]);
        return $stmt->fetch();
    }

    public function create($title, $type, $event_date, $description = '') {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (title, type, event_date, description) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$title, $type, $event_date, $description]);
    }

    public function update($id, $title, $type, $event_date, $description) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET title = ?, type = ?, event_date = ?, description = ? WHERE id = ?");
        return $stmt->execute([$title, $type, $event_date, $description, $id]);
    }
}
