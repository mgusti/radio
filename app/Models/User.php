<?php

namespace App\Models;

class User extends Model {
    protected $table = 'users';

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function create($username, $password, $author_name = '') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (username, password, author_name) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $hash, $author_name]);
    }

    public function update($id, $username, $password = null, $author_name = null) {
        if ($password !== null && $author_name !== null) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE {$this->table} SET username = ?, password = ?, author_name = ? WHERE id = ?");
            return $stmt->execute([$username, $hash, $author_name, $id]);
        }

        if ($password !== null) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE {$this->table} SET username = ?, password = ? WHERE id = ?");
            return $stmt->execute([$username, $hash, $id]);
        }

        if ($author_name !== null) {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET username = ?, author_name = ? WHERE id = ?");
            return $stmt->execute([$username, $author_name, $id]);
        }

        $stmt = $this->db->prepare("UPDATE {$this->table} SET username = ? WHERE id = ?");
        return $stmt->execute([$username, $id]);
    }

    public function allRegularUsers() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE id <> 1 ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function resetPassword($id, $newPassword) {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE {$this->table} SET password = ? WHERE id = ?");
        return $stmt->execute([$hash, $id]);
    }
}
