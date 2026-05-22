<?php
$activeSection = 'settings';
require_once __DIR__ . '/layout_header.php';
?>

<div class="max-w-4xl">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Pengaturan</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola akun dan keamanan sistem Anda.</p>
    </div>

    <?php if (isset($_SESSION['success_msg'])): ?>
        <div class="bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 p-4 rounded-xl mb-6 border border-green-100 dark:border-green-500/20 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3"><i class="bi bi-check-circle-fill"></i><?= htmlspecialchars($_SESSION['success_msg']) ?></div>
            <button onclick="this.parentElement.remove()"><i class="bi bi-x-lg"></i></button>
        </div>
        <?php unset($_SESSION['success_msg']); ?>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 p-4 rounded-xl mb-6 border border-red-100 dark:border-red-500/20 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3"><i class="bi bi-exclamation-triangle-fill"></i><?= htmlspecialchars($error) ?></div>
            <button onclick="this.parentElement.remove()"><i class="bi bi-x-lg"></i></button>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Profile Settings -->
        <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 p-8">
            <h3 class="text-lg font-bold mb-6 flex items-center gap-2 text-gray-900 dark:text-white">
                <div class="w-8 h-8 bg-blue-50 dark:bg-blue-500/10 rounded-lg flex items-center justify-center">
                    <i class="bi bi-person-circle text-blue-500 text-sm"></i>
                </div>
                <?= ($_SESSION['is_super_admin'] ?? false) ? 'Profil Admin' : 'Profil User' ?>
            </h3>
            <form action="/<?= ADMIN_SLUG ?>/settings" method="POST" class="flex flex-col gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Username</label>
                    <input type="text" name="username" required value="<?= htmlspecialchars($user['username']) ?>"
                           pattern="[a-z0-9]+" title="Hanya huruf kecil dan angka, tanpa spasi"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white">
                    <p class="text-[11px] text-gray-400 mt-1">Gunakan huruf kecil dan angka saja. Spasi tidak diperbolehkan.</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Penulis</label>
                    <input type="text" name="author_name" required value="<?= htmlspecialchars($authorName) ?>"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white">
                    <p class="text-[11px] text-gray-400 mt-1">Nama ini akan ditampilkan sebagai penulis berita.</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password Baru <span class="text-gray-400 font-normal text-xs">(kosongkan jika tidak ingin diubah)</span></label>
                    <input type="password" name="password"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white">
                </div>
                <button type="submit" class="bg-black dark:bg-white text-white dark:text-black px-6 py-3 rounded-xl font-semibold hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-sm mt-2 flex items-center gap-2 justify-center">
                    <i class="bi bi-person-check"></i> Perbarui Profil
                </button>
            </form>
        </div>

        <!-- Security Settings -->
        <?php if ($_SESSION['is_super_admin'] ?? false): ?>
            <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 p-8">
                <h3 class="text-lg font-bold mb-2 flex items-center gap-2 text-red-600 dark:text-red-500">
                    <div class="w-8 h-8 bg-red-50 dark:bg-red-500/10 rounded-lg flex items-center justify-center">
                        <i class="bi bi-shield-lock text-red-500 text-sm"></i>
                    </div>
                    URL Keamanan
                </h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">
                    Ubah URL halaman admin. Saat ini: <code class="bg-gray-100 dark:bg-white/5 px-2 py-0.5 rounded text-gray-900 dark:text-white font-mono text-xs">/<?= ADMIN_SLUG ?></code>
                </p>
                <form action="/<?= ADMIN_SLUG ?>/settings/slug" method="POST" class="flex flex-col gap-5"
                      onsubmit="return confirm('Peringatan: Mengubah URL admin akan mengalihkan Anda. Jangan lupa alamat barunya!');">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Slug URL Admin</label>
                        <div class="flex items-center bg-gray-100 dark:bg-white/5 rounded-xl border border-gray-200 dark:border-white/10 overflow-hidden focus-within:ring-2 focus-within:ring-red-500 transition-all">
                            <span class="px-4 text-gray-400 font-medium text-sm">/</span>
                            <input type="text" name="admin_slug" required value="<?= htmlspecialchars(ADMIN_SLUG) ?>"
                                   class="flex-1 px-2 py-3 bg-transparent border-none focus:outline-none text-gray-900 dark:text-white font-bold">
                        </div>
                    </div>
                    <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-red-700 transition-colors shadow-sm mt-2 flex items-center gap-2 justify-center">
                        <i class="bi bi-shield-exclamation"></i> Ubah Slug URL
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
