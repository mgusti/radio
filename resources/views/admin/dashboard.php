<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Dashboard') ?></title>
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
                <a href="/radio/<?= ADMIN_SLUG ?>" class="text-sm font-medium hover:text-black transition-colors <?= (!isset($_GET['id']) && strpos($_SERVER['REQUEST_URI'], 'settings') === false) ? 'text-black' : 'text-gray-500' ?>">Dashboard</a>
                <a href="/radio/<?= ADMIN_SLUG ?>/settings" class="text-sm font-medium hover:text-black transition-colors <?= (strpos($_SERVER['REQUEST_URI'], 'settings') !== false) ? 'text-black' : 'text-gray-500' ?>">Settings</a>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-gray-600">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="/radio/<?= ADMIN_SLUG ?>/logout" class="text-sm text-red-500 hover:text-red-700 font-medium bg-red-50 px-4 py-2 rounded-lg hover:bg-red-100 transition-colors">Logout</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto p-6 mt-6">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Manage News</h1>
                <p class="text-gray-500 mt-1">Add, edit, or delete news articles.</p>
            </div>
            <a href="/radio/<?= ADMIN_SLUG ?>/news/create" class="bg-black text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-800 transition-colors shadow-lg hover:shadow-xl flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Create News
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 text-sm">
                        <th class="py-4 px-6 font-medium">Image</th>
                        <th class="py-4 px-6 font-medium">Title</th>
                        <th class="py-4 px-6 font-medium">Author</th>
                        <th class="py-4 px-6 font-medium">Date</th>
                        <th class="py-4 px-6 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($news)): ?>
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">No news found. Create some!</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($news as $item): ?>
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="py-4 px-6">
                                    <div class="w-16 h-12 rounded-lg bg-gray-200 overflow-hidden">
                                        <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="Cover" class="w-full h-full object-cover">
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-medium text-gray-900"><?= htmlspecialchars($item['title']) ?></td>
                                <td class="py-4 px-6 text-gray-500"><?= htmlspecialchars($item['author']) ?></td>
                                <td class="py-4 px-6 text-gray-500"><?= date('M d, Y', strtotime($item['date'] ?? $item['created_at'])) ?></td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="/radio/<?= ADMIN_SLUG ?>/news/edit?id=<?= $item['id'] ?>" class="text-blue-500 hover:text-blue-700 bg-blue-50 p-2 rounded-lg hover:bg-blue-100 transition-colors">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="/radio/<?= ADMIN_SLUG ?>/news/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this news?');" class="inline">
                                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                            <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded-lg hover:bg-red-100 transition-colors">
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
</body>
</html>
