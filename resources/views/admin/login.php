<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Login Admin') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen text-gray-800">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Login Admin</h1>
            <p class="text-gray-500 mt-2">Gibel fm Control Panel</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="bg-red-50 text-red-500 p-4 rounded-lg mb-6 text-sm border border-red-100">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="/radio/<?= ADMIN_SLUG ?>/login" method="POST" class="flex flex-col gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" required 
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required 
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>
            <button type="submit" 
                    class="w-full bg-black text-white rounded-xl py-3 font-medium hover:bg-gray-800 transition-colors mt-2 shadow-lg hover:shadow-xl">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>
