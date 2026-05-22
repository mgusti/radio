<?php
$activeSection = 'users';
require_once __DIR__ . '/layout_header.php';
?>

<div class="max-w-6xl">
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Kelola User</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Super admin dapat membuat, mengubah, menghapus, dan mereset password user biasa.</p>
        </div>
        <a href="/<?= ADMIN_SLUG ?>/users/create" class="inline-flex items-center gap-2 bg-black dark:bg-white text-white dark:text-black px-4 py-3 rounded-xl text-sm font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
            <i class="bi bi-plus-lg"></i> Tambah User
        </a>
    </div>

    <?php if (isset($_SESSION['success_msg'])): ?>
        <div class="bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 p-4 rounded-xl mb-6 border border-green-100 dark:border-green-500/20 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3"><i class="bi bi-check-circle-fill"></i><?= htmlspecialchars($_SESSION['success_msg']) ?></div>
            <button onclick="this.parentElement.remove()"><i class="bi bi-x-lg"></i></button>
        </div>
        <?php unset($_SESSION['success_msg']); ?>
    <?php endif; ?>

    <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-white/5">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar User</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Super admin (initial user) tidak ditampilkan di sini.</p>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/5 border-b border-gray-100 dark:border-white/5 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                    <th class="py-3 px-6 font-medium">Username</th>
                    <th class="py-3 px-6 font-medium">Nama Penulis</th>
                    <th class="py-3 px-6 font-medium">Dibuat</th>
                    <th class="py-3 px-6 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                <?php if (empty($users)): ?>
                    <tr><td colspan="4" class="py-10 text-center text-gray-400">Belum ada user biasa.</td></tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.03] transition-colors group">
                            <td class="py-4 px-6 font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($user['username']) ?></td>
                            <td class="py-4 px-6 text-gray-500 dark:text-gray-400"><?= htmlspecialchars($user['author_name']) ?></td>
                            <td class="py-4 px-6 text-sm text-gray-500"><?= date('d M Y', strtotime($user['created_at'] ?? 'now')) ?></td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex flex-wrap justify-end gap-2">
                                    <a href="/<?= ADMIN_SLUG ?>/users/edit?id=<?= $user['id'] ?>" class="text-blue-500 hover:text-blue-700 bg-blue-50 dark:bg-blue-500/10 p-2 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-500/20 transition-colors">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="/<?= ADMIN_SLUG ?>/users/reset-password" method="POST" class="inline">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <button type="submit" class="text-amber-500 hover:text-amber-700 bg-amber-50 dark:bg-amber-500/10 p-2 rounded-lg hover:bg-amber-100 dark:hover:bg-amber-500/20 transition-colors">
                                            <i class="bi bi-key"></i>
                                        </button>
                                    </form>
                                    <form action="/<?= ADMIN_SLUG ?>/users/delete" method="POST" onsubmit="return confirm('Yakin mau hapus user ini?');" class="inline">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 dark:bg-red-500/10 p-2 rounded-lg hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors">
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
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
