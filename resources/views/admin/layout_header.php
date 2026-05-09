<?php
/**
 * Admin Layout Header
 * Include at the top of every admin page.
 * Requires: $title (string), $activeSection ('news'|'calendar'|'settings'|'dashboard')
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'User Panel') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .sidebar-link { @apply flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all; }
        .sidebar-link.active { @apply bg-black dark:bg-white text-white dark:text-black; }
        .sidebar-link:not(.active) { @apply text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-[#0a0a0a] text-gray-800 dark:text-gray-200 transition-colors duration-300 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white dark:bg-[#121212] border-r border-gray-100 dark:border-white/5 flex flex-col flex-shrink-0 h-screen sticky top-0">
        <!-- Logo -->
        <div class="p-6 border-b border-gray-100 dark:border-white/5">
            <a href="/radio/<?= ADMIN_SLUG ?>" class="flex items-center gap-3">
                <div class="w-9 h-9 bg-black dark:bg-white rounded-xl flex items-center justify-center flex-shrink-0">
                    <div class="w-3.5 h-3.5 bg-white dark:bg-black rounded-full"></div>
                </div>
                <div>
                    <span class="font-bold text-lg text-gray-900 dark:text-white leading-none block">GibelFm</span>
                    <span class="text-xs text-gray-400 font-medium tracking-wider uppercase"><?= ($_SESSION['is_super_admin'] ?? false) ? 'Admin Panel' : 'User Panel' ?></span>
                </div>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-600 px-4 pt-2 pb-1">Main</p>
            <a href="/radio/<?= ADMIN_SLUG ?>" class="sidebar-link <?= $activeSection === 'dashboard' ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill text-base"></i>
                <span>Dashboard</span>
            </a>

            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-600 px-4 pt-4 pb-1">News</p>
            <a href="/radio/<?= ADMIN_SLUG ?>/news" class="sidebar-link <?= $activeSection === 'news' ? 'active' : '' ?>">
                <i class="bi bi-newspaper text-base"></i>
                <span>All News</span>
            </a>

            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-600 px-4 pt-4 pb-1">Calendar</p>
            <a href="/radio/<?= ADMIN_SLUG ?>/calendar" class="sidebar-link <?= $activeSection === 'calendar' ? 'active' : '' ?>">
                <i class="bi bi-calendar3 text-base"></i>
                <span>All Events</span>
            </a>

            <?php if ($_SESSION['is_super_admin'] ?? false): ?>
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-600 px-4 pt-4 pb-1">Users</p>
                <a href="/radio/<?= ADMIN_SLUG ?>/users" class="sidebar-link <?= $activeSection === 'users' ? 'active' : '' ?>">
                    <i class="bi bi-people-fill text-base"></i>
                    <span>Manage Users</span>
                </a>
            <?php endif; ?>

            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-600 px-4 pt-4 pb-1">System</p>
            <a href="/radio/<?= ADMIN_SLUG ?>/settings" class="sidebar-link <?= $activeSection === 'settings' ? 'active' : '' ?>">
                <i class="bi bi-gear-fill text-base"></i>
                <span>Settings</span>
            </a>
        </nav>

        <!-- Bottom User Info -->
        <div class="p-4 border-t border-gray-100 dark:border-white/5">
            <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                <div class="w-9 h-9 bg-black dark:bg-white rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-white dark:text-black font-bold text-sm"><?= strtoupper(substr($_SESSION['username'] ?? 'A', 0, 1)) ?></span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></p>
                    <p class="text-xs text-gray-400"><?= ($_SESSION['is_super_admin'] ?? false) ? 'Administrator' : 'User' ?></p>
                </div>
                <a href="/radio/<?= ADMIN_SLUG ?>/logout" title="Logout" class="text-red-400 hover:text-red-600 transition-colors">
                    <i class="bi bi-box-arrow-right text-lg"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Bar -->
        <header class="bg-white dark:bg-[#121212] border-b border-gray-100 dark:border-white/5 px-8 py-4 flex justify-between items-center flex-shrink-0">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white"><?= htmlspecialchars($title ?? 'User') ?></h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="/radio/" target="_blank" class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors flex items-center gap-1.5">
                    <i class="bi bi-box-arrow-up-right text-xs"></i> View Site
                </a>
                <button id="theme-toggle" class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 hover:bg-gray-100 dark:hover:bg-white/10 transition-all text-gray-600 dark:text-gray-400">
                    <i class="bi bi-moon-stars-fill dark:hidden text-sm"></i>
                    <i class="bi bi-sun-fill hidden dark:block text-sm"></i>
                </button>
            </div>
        </header>

        <!-- Scrollable Page Content -->
        <main class="flex-1 overflow-y-auto p-8">
