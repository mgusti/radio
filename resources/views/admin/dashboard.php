<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Dashboard') ?></title>
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

    <main class="max-w-7xl mx-auto p-6 mt-6">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Manage News</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Add, edit, or delete news articles.</p>
            </div>
            <a href="/radio/<?= ADMIN_SLUG ?>/news/create" class="bg-black dark:bg-white dark:text-black text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-lg hover:shadow-xl flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Create News
            </a>
        </div>
        
        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 p-4 rounded-xl mb-8 border border-green-100 dark:border-green-500/20 flex items-center justify-between gap-3 animate-in fade-in slide-in-from-top-4 duration-500">
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

        <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/5 border-b border-gray-100 dark:border-gray-800 text-gray-500 dark:text-gray-400 text-sm">
                        <th class="py-4 px-6 font-medium">Image</th>
                        <th class="py-4 px-6 font-medium">Title</th>
                        <th class="py-4 px-6 font-medium">Author</th>
                        <th class="py-4 px-6 font-medium">Date</th>
                        <th class="py-4 px-6 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    <?php if (empty($news)): ?>
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500 dark:text-gray-400">No news found. Create some!</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($news as $item): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors group">
                                <td class="py-4 px-6">
                                    <div class="w-16 h-12 rounded-lg bg-gray-100 dark:bg-white/5 overflow-hidden flex items-center justify-center border border-gray-100 dark:border-white/10">
                                        <?php if (!empty($item['image_url'])): ?>
                                            <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="Cover" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="flex flex-col items-center justify-center text-gray-300 dark:text-gray-600">
                                                <i class="bi bi-image text-lg leading-none"></i>
                                                <span class="text-[8px] font-black uppercase tracking-tighter mt-0.5">No Img</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($item['title']) ?></td>
                                <td class="py-4 px-6 text-gray-500 dark:text-gray-400"><?= htmlspecialchars($item['author']) ?></td>
                                <td class="py-4 px-6 text-gray-500 dark:text-gray-400"><?= date('M d, Y', strtotime($item['date'] ?? $item['created_at'])) ?></td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="/radio/<?= ADMIN_SLUG ?>/news/edit?id=<?= $item['id'] ?>" class="text-blue-500 hover:text-blue-700 bg-blue-50 dark:bg-blue-500/10 p-2 rounded-lg hover:bg-blue-100 transition-colors">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="/radio/<?= ADMIN_SLUG ?>/news/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this news?');" class="inline">
                                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                            <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 dark:bg-red-500/10 p-2 rounded-lg hover:bg-red-100 transition-colors">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
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
