<?php
$activeSection = 'settings';
require_once __DIR__ . '/layout_header.php';
?>

<div class="max-w-4xl">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Settings</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your account and system security.</p>
    </div>

    <?php if (isset($_SESSION['success_msg'])): ?>
        <div class="bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 p-4 rounded-xl mb-6 border border-green-100 dark:border-green-500/20 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3"><i class="bi bi-check-circle-fill"></i><?= htmlspecialchars($_SESSION['success_msg']) ?></div>
            <button onclick="this.parentElement.remove()"><i class="bi bi-x-lg"></i></button>
        </div>
        <?php unset($_SESSION['success_msg']); ?>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Profile Settings -->
        <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 p-8">
            <h3 class="text-lg font-bold mb-6 flex items-center gap-2 text-gray-900 dark:text-white">
                <div class="w-8 h-8 bg-blue-50 dark:bg-blue-500/10 rounded-lg flex items-center justify-center">
                    <i class="bi bi-person-circle text-blue-500 text-sm"></i>
                </div>
                Admin Profile
            </h3>
            <form action="/radio/<?= ADMIN_SLUG ?>/settings" method="POST" class="flex flex-col gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Username</label>
                    <input type="text" name="username" required value="<?= htmlspecialchars($user['username']) ?>"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">New Password <span class="text-gray-400 font-normal text-xs">(leave blank to keep current)</span></label>
                    <input type="password" name="password"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white">
                </div>
                <button type="submit" class="bg-black dark:bg-white text-white dark:text-black px-6 py-3 rounded-xl font-semibold hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-sm mt-2 flex items-center gap-2 justify-center">
                    <i class="bi bi-person-check"></i> Update Profile
                </button>
            </form>
        </div>

        <!-- Security Settings -->
        <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 p-8">
            <h3 class="text-lg font-bold mb-2 flex items-center gap-2 text-red-600 dark:text-red-500">
                <div class="w-8 h-8 bg-red-50 dark:bg-red-500/10 rounded-lg flex items-center justify-center">
                    <i class="bi bi-shield-lock text-red-500 text-sm"></i>
                </div>
                Security URL
            </h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">
                Change the admin URL suffix. Current: <code class="bg-gray-100 dark:bg-white/5 px-2 py-0.5 rounded text-gray-900 dark:text-white font-mono text-xs">/radio/<?= ADMIN_SLUG ?></code>
            </p>
            <form action="/radio/<?= ADMIN_SLUG ?>/settings/slug" method="POST" class="flex flex-col gap-5"
                  onsubmit="return confirm('Warning: Changing the admin URL will redirect you. Remember the new address!');">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Admin URL Slug</label>
                    <div class="flex items-center bg-gray-100 dark:bg-white/5 rounded-xl border border-gray-200 dark:border-white/10 overflow-hidden focus-within:ring-2 focus-within:ring-red-500 transition-all">
                        <span class="px-4 text-gray-400 font-medium text-sm">/radio/</span>
                        <input type="text" name="admin_slug" required value="<?= htmlspecialchars(ADMIN_SLUG) ?>"
                               class="flex-1 px-2 py-3 bg-transparent border-none focus:outline-none text-gray-900 dark:text-white font-bold">
                    </div>
                </div>
                <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-red-700 transition-colors shadow-sm mt-2 flex items-center gap-2 justify-center">
                    <i class="bi bi-shield-exclamation"></i> Change URL Slug
                </button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
