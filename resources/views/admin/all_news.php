<?php
$activeSection = 'news';
require_once __DIR__ . '/layout_header.php';
?>

<!-- Success Message -->
<?php if (isset($_SESSION['success_msg'])): ?>
    <div class="bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 p-4 rounded-xl mb-6 border border-green-100 dark:border-green-500/20 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3"><i class="bi bi-check-circle-fill"></i><?= htmlspecialchars($_SESSION['success_msg']) ?></div>
        <button onclick="this.parentElement.remove()"><i class="bi bi-x-lg"></i></button>
    </div>
    <?php unset($_SESSION['success_msg']); ?>
<?php endif; ?>

<!-- News Table -->
<div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-white/5 flex justify-between items-center">
        <h2 class="text-base font-bold text-gray-900 dark:text-white">Daftar Berita</h2>
        <a href="/radio/<?= ADMIN_SLUG ?>/news/create" class="bg-black dark:bg-white dark:text-black text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Tambah
        </a>
    </div>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 dark:bg-white/5 border-b border-gray-100 dark:border-white/5 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                <th class="py-3 px-6 font-medium">Gambar</th>
                <th class="py-3 px-6 font-medium">Judul</th>
                <th class="py-3 px-6 font-medium">Penulis</th>
                <th class="py-3 px-6 font-medium">Tanggal</th>
                <th class="py-3 px-6 font-medium text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-white/5">
            <?php if (empty($news)): ?>
                <tr><td colspan="5" class="py-10 text-center text-gray-400">Belum ada berita. Yuk buat!</td></tr>
            <?php else: ?>
                <?php foreach ($news as $item): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.03] transition-colors group">
                        <td class="py-4 px-6">
                            <div class="w-16 h-12 rounded-lg bg-gray-100 dark:bg-white/5 overflow-hidden flex items-center justify-center border border-gray-100 dark:border-white/10">
                                <?php if (!empty($item['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="Cover" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <i class="bi bi-image text-gray-300 dark:text-gray-600 text-xl"></i>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="py-4 px-6 font-medium text-gray-900 dark:text-white max-w-xs truncate"><?= htmlspecialchars($item['title']) ?></td>
                        <td class="py-4 px-6 text-sm text-gray-500"><?= htmlspecialchars($item['author']) ?></td>
                        <td class="py-4 px-6 text-sm text-gray-500"><?= date('d M Y', strtotime($item['date'] ?? $item['created_at'])) ?></td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="/radio/<?= ADMIN_SLUG ?>/news/edit?id=<?= $item['id'] ?>" class="text-blue-500 hover:text-blue-700 bg-blue-50 dark:bg-blue-500/10 p-2 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-500/20 transition-colors">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="/radio/<?= ADMIN_SLUG ?>/news/delete" method="POST" onsubmit="return confirm('Yakin mau hapus berita ini?');" class="inline">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
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

<?php require_once __DIR__ . '/layout_footer.php'; ?>
