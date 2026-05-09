<?php

namespace App\Controllers;

use App\Models\User;

class AuthController {
    public function loginForm() {
        // If already logged in, redirect to admin dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: /radio/' . ADMIN_SLUG);
            exit;
        }
        $title = 'Admin Login - GibelFm';
        require_once __DIR__ . '/../../resources/views/admin/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_super_admin'] = $user['id'] === 1;
                header('Location: /radio/' . ADMIN_SLUG);
                exit;
            } else {
                $error = 'Invalid username or password';
                $title = 'Admin Login - GibelFm';
                require_once __DIR__ . '/../../resources/views/admin/login.php';
            }
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /radio/' . ADMIN_SLUG . '/login');
        exit;
    }
}
