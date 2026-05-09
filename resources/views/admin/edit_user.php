<?php
$activeSection = 'users';
require_once __DIR__ . '/layout_header.php';
?>

<div class="max-w-3xl">
    <div class="mb-8">
        <a href="/radio/<?= ADMIN_SLUG ?>/users" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors mb-4">
            <i class="bi bi-arrow-left"></i> Back to Users
        </a>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit User</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update user credentials and author name.</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 p-4 rounded-xl mb-6 border border-red-100 dark:border-red-500/20">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="/radio/<?= ADMIN_SLUG ?>/users/edit?id=<?= $user['id'] ?>" method="POST" class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 p-8 flex flex-col gap-6">
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Username <span class="text-red-500">*</span></label>
            <input type="text" name="username" required value="<?= htmlspecialchars($user['username']) ?>"
                   pattern="[a-z0-9]+" title="Lowercase letters and numbers only, no spaces"
                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white">
            <p class="text-[11px] text-gray-400 mt-1">Lowercase letters and digits only. No spaces.</p>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Author Name <span class="text-red-500">*</span></label>
            <input type="text" name="author_name" required value="<?= htmlspecialchars($user['author_name']) ?>"
                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white">
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-black dark:bg-white dark:text-black text-white px-8 py-3 rounded-xl font-semibold hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-sm flex items-center gap-2">
                <i class="bi bi-check-lg"></i> Save Changes
            </button>
            <a href="/radio/<?= ADMIN_SLUG ?>/users" class="px-8 py-3 rounded-xl font-semibold border border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
