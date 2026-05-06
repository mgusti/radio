<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Settings') ?></title>
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
                <a href="/radio/<?= ADMIN_SLUG ?>/settings" class="text-sm font-medium text-black transition-colors">Settings</a>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-gray-600">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="/radio/<?= ADMIN_SLUG ?>/logout" class="text-sm text-red-500 hover:text-red-700 font-medium bg-red-50 px-4 py-2 rounded-lg hover:bg-red-100 transition-colors">Logout</a>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto p-6 mt-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
            <p class="text-gray-500 mt-1">Manage your account and system security.</p>
        </div>

        <?php if (isset($success)): ?>
            <div class="bg-green-50 text-green-600 p-4 rounded-xl mb-8 border border-green-100 flex items-center gap-3">
                <i class="bi bi-check-circle-fill"></i>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Profile Settings -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <i class="bi bi-person-circle"></i> Admin Profile
                </h2>
                <form action="/radio/<?= ADMIN_SLUG ?>/settings" method="POST" class="flex flex-col gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <input type="text" name="username" required value="<?= htmlspecialchars($user['username']) ?>"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-black transition-all bg-gray-50 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" 
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-black transition-all bg-gray-50 focus:bg-white">
                    </div>
                    <button type="submit" class="bg-black text-white px-6 py-3 rounded-xl font-medium hover:bg-gray-800 transition-colors shadow-lg mt-2">
                        Update Profile
                    </button>
                </form>
            </div>

            <!-- Security Settings -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-red-600">
                    <i class="bi bi-shield-lock"></i> Security URL
                </h2>
                <p class="text-gray-500 text-sm mb-6">Change the admin URL suffix for better security. Current URL: <code class="bg-gray-100 px-2 py-1 rounded text-black">/radio/<?= ADMIN_SLUG ?></code></p>
                
                <form action="/radio/<?= ADMIN_SLUG ?>/settings/slug" method="POST" class="flex flex-col gap-5" onsubmit="return confirm('Warning: Changing the admin URL will redirect you to the new address. Make sure to remember it!');">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Admin URL Slug</label>
                        <div class="flex items-center bg-gray-100 rounded-xl border border-gray-200 overflow-hidden focus-within:ring-2 focus-within:ring-red-500 transition-all">
                            <span class="px-4 text-gray-400 font-medium">/radio/</span>
                            <input type="text" name="admin_slug" required value="<?= htmlspecialchars(ADMIN_SLUG) ?>"
                                   class="flex-1 px-2 py-3 bg-transparent border-none focus:outline-none text-black font-bold">
                        </div>
                    </div>
                    <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-red-700 transition-colors shadow-lg mt-2">
                        Change URL Slug
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
