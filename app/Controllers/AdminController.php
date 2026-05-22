<?php

namespace App\Controllers;

use App\Models\News;
use App\Models\Event;
use App\Models\User;

class AdminController {
    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /' . ADMIN_SLUG . '/login');
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

        $title = $this->isSuperAdmin() ? 'Dashboard Admin - GibelFm' : 'Dashboard User - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/dashboard.php';
    }

    private function isSuperAdmin() {
        return isset($_SESSION['is_super_admin']) && $_SESSION['is_super_admin'];
    }

    private function requireSuperAdmin() {
        if (!$this->isSuperAdmin()) {
            header('Location: /' . ADMIN_SLUG);
            exit;
        }
    }

    public function allNews() {
        $newsModel = new News();
        $news = $newsModel->all();

        $title = 'Semua Berita - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/all_news.php';
    }

    public function users() {
        $this->requireSuperAdmin();

        $userModel = new User();
        $users = $userModel->allRegularUsers();

        $title = 'Kelola User - GibelFm';
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
                $error = 'Username hanya boleh huruf kecil dan angka, tanpa spasi.';
            } elseif (empty($password)) {
                $error = 'Password wajib diisi.';
            } elseif (empty($author_name)) {
                $error = 'Nama penulis wajib diisi.';
            } elseif ($userModel->findByUsername($username)) {
                $error = 'Username sudah terpakai.';
            } else {
                $userModel->create($username, $password, $author_name);
                $_SESSION['success_msg'] = 'User berhasil ditambahkan!';
                header('Location: /' . ADMIN_SLUG . '/users');
                exit;
            }
        }

        $title = 'Tambah User - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/create_user.php';
    }

    public function editUser() {
        $this->requireSuperAdmin();

        $id = $_GET['id'] ?? null;
        if (!$id || $id == 1) {
            header('Location: /' . ADMIN_SLUG . '/users');
            exit;
        }

        $userModel = new User();
        $user = $userModel->find($id);
        if (!$user) {
            header('Location: /' . ADMIN_SLUG . '/users');
            exit;
        }

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $author_name = trim($_POST['author_name'] ?? '');

            if (!preg_match('/^[a-z0-9]+$/', $username)) {
                $error = 'Username hanya boleh huruf kecil dan angka, tanpa spasi.';
            } elseif (empty($author_name)) {
                $error = 'Nama penulis harus diisi.';
            } else {
                $existingUser = $userModel->findByUsername($username);
                if ($existingUser && $existingUser['id'] != $id) {
                    $error = 'Username sudah terdaftar.';
                } else {
                    $userModel->update($id, $username, null, $author_name);
                    $_SESSION['success_msg'] = 'User berhasil diperbarui!';
                    header('Location: /' . ADMIN_SLUG . '/users');
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
                $_SESSION['success_msg'] = 'User berhasil dihapus!';
            }
        }
        header('Location: /' . ADMIN_SLUG . '/users');
        exit;
    }

    public function resetUserPassword() {
        $this->requireSuperAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id && $id != 1) {
                $userModel = new User();
                $userModel->resetPassword($id, '12345678');
                $_SESSION['success_msg'] = 'Password berhasil direset ke 12345678.';
            }
        }
        header('Location: /' . ADMIN_SLUG . '/users');
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
                $error = 'Username hanya boleh huruf kecil dan angka, tanpa spasi.';
            } elseif (empty($author_name)) {
                $error = 'Nama penulis harus diisi.';
            } else {
                $existingUser = $userModel->findByUsername($username);
                if ($existingUser && $existingUser['id'] != $_SESSION['user_id']) {
                    $error = 'Username sudah terdaftar.';
                } else {
                    $password = $password !== '' ? $password : null;
                    $userModel->update($_SESSION['user_id'], $username, $password, $author_name);
                    $_SESSION['username'] = $username;
                    $_SESSION['success_msg'] = "Profil berhasil diperbarui!";
                    $user = $userModel->find($_SESSION['user_id']); // Refresh data
                    $authorName = $user['author_name'] ?? $user['username'];
                }
            }
        }

        $title = 'Pengaturan - GibelFm';
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
                $_SESSION['success_msg'] = "URL admin berhasil diperbarui! Slug baru: " . $newSlug;
                header('Location: /' . $newSlug . '/settings');
                exit;
            }
        }
        header('Location: /' . ADMIN_SLUG . '/settings');
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
            
            $_SESSION['success_msg'] = "Berita berhasil dibuat!";
            header('Location: /' . ADMIN_SLUG . '/news');
            exit;
        }
        $title = 'Tambah Berita - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/create_news.php';
    }

    public function editNews() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /' . ADMIN_SLUG . '/news');
            exit;
        }

        $newsModel = new News();
        $news = $newsModel->find($id); // Get current data to check for changes
        if (!$news) {
            header('Location: /' . ADMIN_SLUG . '/news');
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
            
            $_SESSION['success_msg'] = "Berita berhasil diperbarui!";
            header('Location: /' . ADMIN_SLUG . '/news');
            exit;
        }

        $title = 'Edit Berita - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/edit_news.php';
    }

    public function deleteNews() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $newsModel = new News();
                $newsModel->delete($id);
                $_SESSION['success_msg'] = "Berita berhasil dihapus!";
            }
        }
        header('Location: /' . ADMIN_SLUG . '/news');
        exit;
    }

    public function calendar() {
        $eventModel = new Event();
        $events = $eventModel->all();
        $title = 'Jadwal Acara - GibelFm';
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
            
            $_SESSION['success_msg'] = "Acara berhasil dibuat!";
            header('Location: /' . ADMIN_SLUG . '/calendar');
            exit;
        }
        $title = 'Tambah Acara - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/create_event.php';
    }

    public function editEvent() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /' . ADMIN_SLUG . '/calendar');
            exit;
        }

        $eventModel = new Event();
        $event = $eventModel->find($id);
        if (!$event) {
            header('Location: /' . ADMIN_SLUG . '/calendar');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $type = $_POST['type'] ?? 'program';
            $event_date = $_POST['event_date'] ?? date('Y-m-d');
            $description = $_POST['description'] ?? '';

            $eventModel->update($id, $title, $type, $event_date, $description);
            
            $_SESSION['success_msg'] = "Acara berhasil diperbarui!";
            header('Location: /' . ADMIN_SLUG . '/calendar');
            exit;
        }

        $title = 'Edit Acara - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/edit_event.php';
    }

    public function deleteEvent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $eventModel = new Event();
                $eventModel->delete($id);
                $_SESSION['success_msg'] = "Acara berhasil dihapus!";
            }
        }
        header('Location: /' . ADMIN_SLUG . '/calendar');
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
                return '/public/img/' . $filename;
            }
        }
        return null;
    }

    public function editProfile() {
        $profileModel = new \App\Models\Profile();
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $station_name = trim($_POST['station_name'] ?? '');
            $tagline = trim($_POST['tagline'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $vision = trim($_POST['vision'] ?? '');

            // Parse missions: one per line
            $missions_input = $_POST['missions'] ?? '';
            $missions_arr = array_filter(array_map('trim', explode("\n", $missions_input)));
            $missions_arr = array_values($missions_arr); // re-index

            // Parse crew: array of crew members
            $crew_names = $_POST['crew_name'] ?? [];
            $crew_roles = $_POST['crew_role'] ?? [];
            $crew_avatars = $_POST['crew_avatar'] ?? [];
            $crew_fb = $_POST['crew_fb'] ?? [];
            $crew_ig = $_POST['crew_ig'] ?? [];
            $crew_tt = $_POST['crew_tt'] ?? [];

            $crew_arr = [];
            for ($i = 0; $i < count($crew_names); $i++) {
                if (empty(trim($crew_names[$i]))) continue;
                $crew_arr[] = [
                    'name' => trim($crew_names[$i]),
                    'role' => trim($crew_roles[$i] ?? ''),
                    'avatar' => trim($crew_avatars[$i] ?? ''),
                    'social' => [
                        'facebook' => trim($crew_fb[$i] ?? ''),
                        'instagram' => trim($crew_ig[$i] ?? ''),
                        'tiktok' => trim($crew_tt[$i] ?? '')
                    ]
                ];
            }

            // Save to database
            $missions_json = json_encode($missions_arr, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $crew_json = json_encode($crew_arr, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $profileModel->updateProfile($station_name, $tagline, $description, $vision, $missions_json, $crew_json);

            $_SESSION['success_msg'] = 'Profil stasiun radio berhasil diperbarui!';
            header('Location: /' . ADMIN_SLUG . '/profile');
            exit;
        }

        // Load existing values
        $profile = $profileModel->getProfile();
        $station_name = $profile['station_name'];
        $tagline = $profile['tagline'];
        $description = $profile['description'];
        $vision = $profile['vision'];
        
        $missions = json_decode($profile['missions'], true);
        $crew = json_decode($profile['crew'], true);

        // Convert missions back to newline-separated text for the textarea
        $missions_text = implode("\n", $missions);

        $title = 'Edit Profil Stasiun - GibelFm';
        $activeSection = 'profile';
        require_once __DIR__ . '/../../resources/views/admin/edit_profile.php';
    }
}
