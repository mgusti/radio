<?php

namespace App\Models;

class News extends Model {
    protected $table = 'news';

    public function create($title, $excerpt, $content, $image_url, $date, $author = 'Admin') {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (title, excerpt, content, image_url, date, author) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$title, $excerpt, $content, $image_url, $date, $author]);
    }

    public function update($id, $title, $excerpt, $content, $image_url, $date, $author = null) {
        if ($author !== null) {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET title = ?, excerpt = ?, content = ?, image_url = ?, date = ?, author = ? WHERE id = ?");
            return $stmt->execute([$title, $excerpt, $content, $image_url, $date, $author, $id]);
        }

        $stmt = $this->db->prepare("UPDATE {$this->table} SET title = ?, excerpt = ?, content = ?, image_url = ?, date = ? WHERE id = ?");
        return $stmt->execute([$title, $excerpt, $content, $image_url, $date, $id]);
    }
}
