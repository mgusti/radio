<?php

namespace App\Models;

class Event extends Model {
    protected $table = 'events';

    public function create($title, $type, $event_date, $description = '') {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (title, type, event_date, description) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$title, $type, $event_date, $description]);
    }

    public function update($id, $title, $type, $event_date, $description) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET title = ?, type = ?, event_date = ?, description = ? WHERE id = ?");
        return $stmt->execute([$title, $type, $event_date, $description, $id]);
    }
}
