<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Create News') ?></title>
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
                <a href="/radio/<?= ADMIN_SLUG ?>" class="text-sm font-medium hover:text-black dark:hover:text-white transition-colors <?= (strpos($_SERVER['REQUEST_URI'], 'news') === false && strpos($_SERVER['REQUEST_URI'], 'settings') === false) ? 'text-black dark:text-white' : 'text-gray-500' ?>">Dashboard</a>
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

    <main class="max-w-3xl mx-auto p-6 mt-6">
        <div class="mb-6 flex items-center gap-4">
            <a href="/radio/<?= ADMIN_SLUG ?>" class="w-10 h-10 bg-white dark:bg-[#121212] border border-gray-200 dark:border-gray-800 rounded-full flex items-center justify-center hover:bg-gray-50 dark:hover:bg-white/5 transition-colors shadow-sm text-gray-900 dark:text-white">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create News</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Publish a new article to the site.</p>
            </div>
        </div>

        <form action="/radio/<?= ADMIN_SLUG ?>/news/create" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-8 flex flex-col gap-6 transition-colors">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                <input type="text" name="title" required 
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all bg-gray-50 dark:bg-white/5 focus:bg-white dark:focus:bg-black text-gray-900 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Excerpt (Short description)</label>
                <textarea name="excerpt" rows="2" required 
                          class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all bg-gray-50 dark:bg-white/5 focus:bg-white dark:focus:bg-black text-gray-900 dark:text-white"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Display Date</label>
                <input type="date" name="date" required value="<?= date('Y-m-d') ?>"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all bg-gray-50 dark:bg-white/5 focus:bg-white dark:focus:bg-black text-gray-900 dark:text-white">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image URL</label>
                    <input type="url" name="image_url" placeholder="https://images.unsplash.com/..."
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all bg-gray-50 dark:bg-white/5 focus:bg-white dark:focus:bg-black text-gray-900 dark:text-white text-sm">
                    <p class="text-[10px] text-gray-400 mt-1 italic">Optional if uploading a file</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Image File</label>
                    <input type="file" name="image_file" accept="image/*"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all bg-gray-50 dark:bg-white/5 focus:bg-white dark:focus:bg-black text-gray-900 dark:text-white text-sm file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-black dark:file:bg-white file:text-white dark:file:text-black hover:file:bg-gray-800 transition-all cursor-pointer">
                    <div class="flex justify-between mt-1 px-1">
                        <span class="text-[10px] text-gray-400 italic">Max size: 2MB</span>
                        <span class="text-[10px] text-blue-500 font-bold italic">Recommended: 1200x800 px</span>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Content</label>
                <textarea name="content" rows="6" required 
                          class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all bg-gray-50 dark:bg-white/5 focus:bg-white dark:focus:bg-black text-gray-900 dark:text-white"></textarea>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-black dark:bg-white text-white dark:text-black px-8 py-3 rounded-xl font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-lg hover:shadow-xl">
                    Publish News
                </button>
            </div>
        </form>
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
