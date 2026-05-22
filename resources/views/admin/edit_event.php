<?php
$activeSection = 'calendar';
require_once __DIR__ . '/layout_header.php';
?>

<div class="max-w-2xl">
    <div class="mb-8">
        <a href="/<?= ADMIN_SLUG ?>/calendar" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors mb-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Acara</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Ubah detail untuk acara ini.</p>
    </div>

    <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 p-8">
        <form action="/<?= ADMIN_SLUG ?>/calendar/edit?id=<?= $event['id'] ?>" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Acara <span class="text-red-500">*</span></label>
                <input type="text" name="title" required value="<?= htmlspecialchars($event['title']) ?>"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tipe <span class="text-red-500">*</span></label>
                    <select name="type" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all">
                        <option value="program" <?= $event['type'] === 'program' ? 'selected' : '' ?>>📻 Program Siaran</option>
                        <option value="event" <?= $event['type'] === 'event' ? 'selected' : '' ?>>📅 Acara Komunitas</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="event_date" required value="<?= htmlspecialchars($event['event_date']) ?>"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all resize-none"><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-black dark:bg-white dark:text-black text-white px-8 py-3 rounded-xl font-semibold hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-sm flex items-center gap-2">
                    <i class="bi bi-check-lg"></i> Simpan Perubahan
                </button>
                <a href="/<?= ADMIN_SLUG ?>/calendar" class="px-8 py-3 rounded-xl font-semibold border border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
