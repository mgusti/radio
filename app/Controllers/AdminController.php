<?php

namespace App\Controllers;

use App\Models\News;

class AdminController {
    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /radio/' . ADMIN_SLUG . '/login');
            exit;
        }
    }

    public function dashboard() {
        $newsModel = new News();
        $news = $newsModel->all();
        $title = 'Admin Dashboard - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/dashboard.php';
    }

    public function settings() {
        $userModel = new \App\Models\User();
        $user = $userModel->find($_SESSION['user_id']);
        
        $settingModel = new \App\Models\Setting();
        $adminSlug = $settingModel->get('admin_slug', 'admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $userModel->update($_SESSION['user_id'], $username, $password ? $password : null);
            $_SESSION['username'] = $username;
            $success = "Profile updated successfully!";
            $user = $userModel->find($_SESSION['user_id']); // Refresh data
        }

        $title = 'Settings - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/settings.php';
    }

    public function updateSlug() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newSlug = $_POST['admin_slug'] ?? 'admin';
            // Simple validation: alphanumeric only, no spaces
            $newSlug = preg_replace('/[^a-zA-Z0-9]/', '', $newSlug);
            
            if (!empty($newSlug)) {
                $settingModel = new \App\Models\Setting();
                $settingModel->set('admin_slug', $newSlug);
                header('Location: /radio/' . $newSlug . '/settings');
                exit;
            }
        }
        header('Location: /radio/' . ADMIN_SLUG . '/settings');
        exit;
    }

    public function createNews() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $excerpt = $_POST['excerpt'] ?? '';
            $content = $_POST['content'] ?? '';
            $image_url = $_POST['image_url'] ?? '';
            $date = $_POST['date'] ?? date('Y-m-d');

            $newsModel = new News();
            $newsModel->create($title, $excerpt, $content, $image_url, $date);
            
            header('Location: /radio/' . ADMIN_SLUG);
            exit;
        }
        $title = 'Create News - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/create_news.php';
    }

    public function editNews() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /radio/' . ADMIN_SLUG);
            exit;
        }

        $newsModel = new News();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $excerpt = $_POST['excerpt'] ?? '';
            $content = $_POST['content'] ?? '';
            $image_url = $_POST['image_url'] ?? '';
            $date = $_POST['date'] ?? date('Y-m-d');

            $newsModel->update($id, $title, $excerpt, $content, $image_url, $date);
            
            header('Location: /radio/' . ADMIN_SLUG);
            exit;
        }

        $news = $newsModel->find($id);
        if (!$news) {
            header('Location: /radio/' . ADMIN_SLUG);
            exit;
        }

        $title = 'Edit News - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/edit_news.php';
    }

    public function deleteNews() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $newsModel = new News();
                $newsModel->delete($id);
            }
        }
        header('Location: /radio/' . ADMIN_SLUG);
        exit;
    }
}
