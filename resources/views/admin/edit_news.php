<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Edit News') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center">
                <div class="w-3 h-3 bg-white rounded-full"></div>
            </div>
            <span class="font-bold text-xl tracking-tight">Pulse<span class="text-gray-400">Admin</span></span>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-4 border-r border-gray-200 pr-6">
                <a href="/radio/<?= ADMIN_SLUG ?>" class="text-sm font-medium text-gray-500 hover:text-black transition-colors">Dashboard</a>
                <a href="/radio/<?= ADMIN_SLUG ?>/settings" class="text-sm font-medium text-gray-500 hover:text-black transition-colors">Settings</a>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-gray-600">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="/radio/<?= ADMIN_SLUG ?>/logout" class="text-sm text-red-500 hover:text-red-700 font-medium bg-red-50 px-4 py-2 rounded-lg hover:bg-red-100 transition-colors">Logout</a>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto p-6 mt-6">
        <div class="mb-6 flex items-center gap-4">
            <a href="/radio/<?= ADMIN_SLUG ?>" class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors shadow-sm">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit News</h1>
                <p class="text-gray-500 mt-1">Update the content of this article.</p>
            </div>
        </div>

        <form action="/radio/<?= ADMIN_SLUG ?>/news/edit?id=<?= $news['id'] ?>" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" name="title" required value="<?= htmlspecialchars($news['title']) ?>"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all bg-gray-50 focus:bg-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt (Short description)</label>
                <textarea name="excerpt" rows="2" required 
                          class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all bg-gray-50 focus:bg-white"><?= htmlspecialchars($news['excerpt']) ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Display Date</label>
                <input type="date" name="date" required value="<?= htmlspecialchars($news['date'] ?? date('Y-m-d')) ?>"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all bg-gray-50 focus:bg-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image URL</label>
                <input type="url" name="image_url" required value="<?= htmlspecialchars($news['image_url']) ?>"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all bg-gray-50 focus:bg-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Full Content</label>
                <textarea name="content" rows="6" required 
                          class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all bg-gray-50 focus:bg-white"><?= htmlspecialchars($news['content']) ?></textarea>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-black text-white px-8 py-3 rounded-xl font-medium hover:bg-gray-800 transition-colors shadow-lg hover:shadow-xl">
                    Save Changes
                </button>
            </div>
        </form>
    </main>
</body>
</html>
