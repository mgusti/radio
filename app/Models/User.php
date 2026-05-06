<?php

namespace App\Models;

class User extends Model {
    protected $table = 'users';

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function create($username, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hash]);
    }

    public function update($id, $username, $password = null) {
        if ($password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE {$this->table} SET username = ?, password = ? WHERE id = ?");
            return $stmt->execute([$username, $hash, $id]);
        } else {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET username = ? WHERE id = ?");
            return $stmt->execute([$username, $id]);
        }
    }
}
