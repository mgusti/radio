<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Settings') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
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
    </style>
</head>
<body class="bg-gray-50 dark:bg-[#0a0a0a] text-gray-800 dark:text-gray-200 transition-colors duration-300">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-[#121212] border-b border-gray-200 dark:border-gray-800 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-black dark:bg-white rounded-full flex items-center justify-center">
                <div class="w-3 h-3 bg-white dark:bg-black rounded-full"></div>
            </div>
            <span class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">Gibel fm<span class="text-gray-400">Admin</span></span>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-4 border-r border-gray-200 dark:border-gray-800 pr-6">
                <a href="/radio/<?= ADMIN_SLUG ?>" class="text-sm font-medium hover:text-black dark:hover:text-white transition-colors <?= (!isset($_GET['id']) && strpos($_SERVER['REQUEST_URI'], 'settings') === false) ? 'text-black dark:text-white' : 'text-gray-500' ?>">Dashboard</a>
                <a href="/radio/<?= ADMIN_SLUG ?>/settings" class="text-sm font-medium hover:text-black dark:hover:text-white transition-colors <?= (strpos($_SERVER['REQUEST_URI'], 'settings') !== false) ? 'text-black dark:text-white' : 'text-gray-500' ?>">Settings</a>
                
                <button id="theme-toggle" class="ml-2 w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 hover:bg-gray-100 dark:hover:bg-white/10 transition-all text-gray-600 dark:text-gray-400">
                    <i class="bi bi-moon-stars-fill dark:hidden"></i>
                    <i class="bi bi-sun-fill hidden dark:block"></i>
                </button>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="/radio/<?= ADMIN_SLUG ?>/logout" class="text-sm text-red-500 hover:text-red-700 font-medium bg-red-50 dark:bg-red-500/10 px-4 py-2 rounded-lg hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors">Logout</a>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto p-6 mt-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Settings</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Manage your account and system security.</p>
        </div>

        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="bg-green-50 text-green-600 p-4 rounded-xl mb-8 border border-green-100 flex items-center justify-between gap-3 animate-in fade-in slide-in-from-top-4 duration-500">
                <div class="flex items-center gap-3">
                    <i class="bi bi-check-circle-fill"></i>
                    <?= htmlspecialchars($_SESSION['success_msg']) ?>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600 transition-colors">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <?php unset($_SESSION['success_msg']); ?>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Profile Settings -->
            <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-8 transition-colors">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-gray-900 dark:text-white">
                    <i class="bi bi-person-circle"></i> Admin Profile
                </h2>
                <form action="/radio/<?= ADMIN_SLUG ?>/settings" method="POST" class="flex flex-col gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username</label>
                        <input type="text" name="username" required value="<?= htmlspecialchars($user['username']) ?>"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-800 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-all bg-gray-50 dark:bg-white/5 focus:bg-white dark:focus:bg-black text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" 
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-800 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-all bg-gray-50 dark:bg-white/5 focus:bg-white dark:focus:bg-black text-gray-900 dark:text-white">
                    </div>
                    <button type="submit" class="bg-black dark:bg-white text-white dark:text-black px-6 py-3 rounded-xl font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-lg mt-2">
                        Update Profile
                    </button>
                </form>
            </div>

            <!-- Security Settings -->
            <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-8 transition-colors">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-red-600 dark:text-red-500">
                    <i class="bi bi-shield-lock"></i> Security URL
                </h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Change the admin URL suffix for better security. Current URL: <code class="bg-gray-100 dark:bg-white/5 px-2 py-1 rounded text-black dark:text-white">/radio/<?= ADMIN_SLUG ?></code></p>
                
                <form action="/radio/<?= ADMIN_SLUG ?>/settings/slug" method="POST" class="flex flex-col gap-5" onsubmit="return confirm('Warning: Changing the admin URL will redirect you to the new address. Make sure to remember it!');">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Admin URL Slug</label>
                        <div class="flex items-center bg-gray-100 dark:bg-white/5 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden focus-within:ring-2 focus-within:ring-red-500 transition-all">
                            <span class="px-4 text-gray-400 font-medium">/radio/</span>
                            <input type="text" name="admin_slug" required value="<?= htmlspecialchars(ADMIN_SLUG) ?>"
                                   class="flex-1 px-2 py-3 bg-transparent border-none focus:outline-none text-black dark:text-white font-bold">
                        </div>
                    </div>
                    <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-red-700 transition-colors shadow-lg mt-2">
                        Change URL Slug
                    </button>
                </form>
            </div>
        </div>
    </main>
    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        themeToggleBtn.addEventListener('click', function() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        });
    </script>
</body>
</html>
