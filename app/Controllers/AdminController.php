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
            $_SESSION['success_msg'] = "Profile updated successfully!";
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
                $_SESSION['success_msg'] = "Admin URL updated successfully! New slug: " . $newSlug;
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

            // Handle File Upload
            $uploadedPath = $this->handleImageUpload($_FILES['image_file'] ?? null);
            if ($uploadedPath) {
                $image_url = $uploadedPath;
            }

            $newsModel = new News();
            $newsModel->create($title, $excerpt, $content, $image_url, $date);
            
            $_SESSION['success_msg'] = "News created successfully!";
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
        $news = $newsModel->find($id); // Get current data to check for changes
        if (!$news) {
            header('Location: /radio/' . ADMIN_SLUG);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $excerpt = $_POST['excerpt'] ?? '';
            $content = $_POST['content'] ?? '';
            $image_url = $_POST['image_url'] ?? '';
            $date = $_POST['date'] ?? date('Y-m-d');
            $clear_image = isset($_POST['clear_image']);

            // Handle File Upload first (highest priority)
            $uploadedPath = $this->handleImageUpload($_FILES['image_file'] ?? null);
            
            if ($uploadedPath) {
                // Priority 1: New file upload
                $image_url = $uploadedPath;
            } elseif (!empty($image_url)) {
                // Priority 2: New URL provided in the input field
                // $image_url already contains $_POST['image_url']
            } elseif ($clear_image) {
                // Priority 3: Explicit removal
                $image_url = '';
            } else {
                // Default: Keep current image
                $image_url = $news['image_url'];
            }

            $newsModel->update($id, $title, $excerpt, $content, $image_url, $date);
            
            $_SESSION['success_msg'] = "News updated successfully!";
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
                $_SESSION['success_msg'] = "News deleted successfully!";
            }
        }
        header('Location: /radio/' . ADMIN_SLUG);
        exit;
    }

    private function handleImageUpload($file) {
        if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            if (!in_array($file['type'], $allowedTypes)) {
                return null;
            }
            if ($file['size'] > $maxSize) {
                return null;
            }

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid('news_', true) . '.' . $ext;
            $uploadDir = __DIR__ . '/../../public/img/';
            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                return '/radio/public/img/' . $filename;
            }
        }
        return null;
    }
}
