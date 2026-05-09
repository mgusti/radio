<?php

namespace App\Controllers;

use App\Models\News;
use App\Models\Event;
use App\Models\User;

class AdminController {
    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /radio/' . ADMIN_SLUG . '/login');
            exit;
        }

        if (!isset($_SESSION['is_super_admin'])) {
            $_SESSION['is_super_admin'] = ($_SESSION['user_id'] ?? null) === 1;
        }
    }

    public function dashboard() {
        $newsModel = new News();
        $news = $newsModel->all();

        $eventModel = new Event();
        $currentEvent = $eventModel->current();
        $upcomingEvent = $eventModel->upcoming();
        $latestEvent = $eventModel->latest();

        $title = $this->isSuperAdmin() ? 'Admin Dashboard - GibelFm' : 'User Dashboard - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/dashboard.php';
    }

    private function isSuperAdmin() {
        return isset($_SESSION['is_super_admin']) && $_SESSION['is_super_admin'];
    }

    private function requireSuperAdmin() {
        if (!$this->isSuperAdmin()) {
            header('Location: /radio/' . ADMIN_SLUG);
            exit;
        }
    }

    public function allNews() {
        $newsModel = new News();
        $news = $newsModel->all();

        $title = 'All News - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/all_news.php';
    }

    public function users() {
        $this->requireSuperAdmin();

        $userModel = new User();
        $users = $userModel->allRegularUsers();

        $title = 'User Management - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/users.php';
    }

    public function createUser() {
        $this->requireSuperAdmin();

        $userModel = new User();
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $author_name = trim($_POST['author_name'] ?? '');

            if (!preg_match('/^[a-z0-9]+$/', $username)) {
                $error = 'Username must contain only lowercase letters and numbers, without spaces.';
            } elseif (empty($password)) {
                $error = 'Password is required.';
            } elseif (empty($author_name)) {
                $error = 'Author name is required.';
            } elseif ($userModel->findByUsername($username)) {
                $error = 'Username already exists.';
            } else {
                $userModel->create($username, $password, $author_name);
                $_SESSION['success_msg'] = 'User created successfully!';
                header('Location: /radio/' . ADMIN_SLUG . '/users');
                exit;
            }
        }

        $title = 'Create User - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/create_user.php';
    }

    public function editUser() {
        $this->requireSuperAdmin();

        $id = $_GET['id'] ?? null;
        if (!$id || $id == 1) {
            header('Location: /radio/' . ADMIN_SLUG . '/users');
            exit;
        }

        $userModel = new User();
        $user = $userModel->find($id);
        if (!$user) {
            header('Location: /radio/' . ADMIN_SLUG . '/users');
            exit;
        }

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $author_name = trim($_POST['author_name'] ?? '');

            if (!preg_match('/^[a-z0-9]+$/', $username)) {
                $error = 'Username must contain only lowercase letters and numbers, without spaces.';
            } elseif (empty($author_name)) {
                $error = 'Author name is required.';
            } else {
                $existingUser = $userModel->findByUsername($username);
                if ($existingUser && $existingUser['id'] != $id) {
                    $error = 'Username already exists.';
                } else {
                    $userModel->update($id, $username, null, $author_name);
                    $_SESSION['success_msg'] = 'User updated successfully!';
                    header('Location: /radio/' . ADMIN_SLUG . '/users');
                    exit;
                }
            }
        }

        $title = 'Edit User - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/edit_user.php';
    }

    public function deleteUser() {
        $this->requireSuperAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id && $id != 1) {
                $userModel = new User();
                $userModel->delete($id);
                $_SESSION['success_msg'] = 'User deleted successfully!';
            }
        }
        header('Location: /radio/' . ADMIN_SLUG . '/users');
        exit;
    }

    public function resetUserPassword() {
        $this->requireSuperAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id && $id != 1) {
                $userModel = new User();
                $userModel->resetPassword($id, '12345678');
                $_SESSION['success_msg'] = 'Password reset to 12345678.';
            }
        }
        header('Location: /radio/' . ADMIN_SLUG . '/users');
        exit;
    }

    public function settings() {
        $userModel = new \App\Models\User();
        $user = $userModel->find($_SESSION['user_id']);
        $authorName = $user['author_name'] ?? $user['username'];
        $adminSlug = $this->isSuperAdmin() ? (new \App\Models\Setting())->get('admin_slug', 'admin') : ADMIN_SLUG;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $author_name = trim($_POST['author_name'] ?? '');

            if (!preg_match('/^[a-z0-9]+$/', $username)) {
                $error = 'Username must contain only lowercase letters and numbers, without spaces.';
            } elseif (empty($author_name)) {
                $error = 'Author name is required.';
            } else {
                $existingUser = $userModel->findByUsername($username);
                if ($existingUser && $existingUser['id'] != $_SESSION['user_id']) {
                    $error = 'Username already exists.';
                } else {
                    $password = $password !== '' ? $password : null;
                    $userModel->update($_SESSION['user_id'], $username, $password, $author_name);
                    $_SESSION['username'] = $username;
                    $_SESSION['success_msg'] = "Profile updated successfully!";
                    $user = $userModel->find($_SESSION['user_id']); // Refresh data
                    $authorName = $user['author_name'] ?? $user['username'];
                }
            }
        }

        $title = 'Settings - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/settings.php';
    }

    public function updateSlug() {
        $this->requireSuperAdmin();

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

            $userModel = new User();
            $currentUser = $userModel->find($_SESSION['user_id']);
            $author = $currentUser['author_name'] ?? $currentUser['username'];

            $newsModel = new News();
            $newsModel->create($title, $excerpt, $content, $image_url, $date, $author);
            
            $_SESSION['success_msg'] = "News created successfully!";
            header('Location: /radio/' . ADMIN_SLUG . '/news');
            exit;
        }
        $title = 'Create News - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/create_news.php';
    }

    public function editNews() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /radio/' . ADMIN_SLUG . '/news');
            exit;
        }

        $newsModel = new News();
        $news = $newsModel->find($id); // Get current data to check for changes
        if (!$news) {
            header('Location: /radio/' . ADMIN_SLUG . '/news');
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

            $userModel = new User();
            $currentUser = $userModel->find($_SESSION['user_id']);
            $author = $currentUser['author_name'] ?? $currentUser['username'];

            $newsModel->update($id, $title, $excerpt, $content, $image_url, $date, $author);
            
            $_SESSION['success_msg'] = "News updated successfully!";
            header('Location: /radio/' . ADMIN_SLUG . '/news');
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
        header('Location: /radio/' . ADMIN_SLUG . '/news');
        exit;
    }

    public function calendar() {
        $eventModel = new Event();
        $events = $eventModel->all();
        $title = 'Calendar Management - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/calendar.php';
    }

    public function createEvent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $type = $_POST['type'] ?? 'program';
            $event_date = $_POST['event_date'] ?? date('Y-m-d');
            $description = $_POST['description'] ?? '';

            $eventModel = new Event();
            $eventModel->create($title, $type, $event_date, $description);
            
            $_SESSION['success_msg'] = "Event created successfully!";
            header('Location: /radio/' . ADMIN_SLUG . '/calendar');
            exit;
        }
        $title = 'Create Event - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/create_event.php';
    }

    public function editEvent() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /radio/' . ADMIN_SLUG . '/calendar');
            exit;
        }

        $eventModel = new Event();
        $event = $eventModel->find($id);
        if (!$event) {
            header('Location: /radio/' . ADMIN_SLUG . '/calendar');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $type = $_POST['type'] ?? 'program';
            $event_date = $_POST['event_date'] ?? date('Y-m-d');
            $description = $_POST['description'] ?? '';

            $eventModel->update($id, $title, $type, $event_date, $description);
            
            $_SESSION['success_msg'] = "Event updated successfully!";
            header('Location: /radio/' . ADMIN_SLUG . '/calendar');
            exit;
        }

        $title = 'Edit Event - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/edit_event.php';
    }

    public function deleteEvent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $eventModel = new Event();
                $eventModel->delete($id);
                $_SESSION['success_msg'] = "Event deleted successfully!";
            }
        }
        header('Location: /radio/' . ADMIN_SLUG . '/calendar');
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
