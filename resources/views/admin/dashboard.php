<?php
$activeSection = 'dashboard';
require_once __DIR__ . '/layout_header.php';
?>

<!-- Stats Row -->
<div class="grid grid-cols-1 sm:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-[#121212] rounded-2xl p-6 border border-gray-100 dark:border-white/5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Berita</p>
            <div class="w-10 h-10 bg-blue-50 dark:bg-blue-500/10 rounded-xl flex items-center justify-center">
                <i class="bi bi-newspaper text-blue-500"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900 dark:text-white"><?= count($news) ?></p>
    </div>
    <div class="bg-white dark:bg-[#121212] rounded-2xl p-6 border border-gray-100 dark:border-white/5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Berita Terbaru</p>
            <div class="w-10 h-10 bg-green-50 dark:bg-green-500/10 rounded-xl flex items-center justify-center">
                <i class="bi bi-clock-history text-green-500"></i>
            </div>
        </div>
        <p class="text-lg font-bold text-gray-900 dark:text-white truncate"><?= !empty($news) ? htmlspecialchars($news[0]['title']) : '—' ?></p>
    </div>
    <div class="bg-amber-50 dark:bg-amber-500/10 rounded-2xl p-6 border border-amber-100 dark:border-amber-500/20 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-amber-600 dark:text-amber-200">Acara Hari Ini</p>
            <div class="w-10 h-10 bg-amber-100 dark:bg-amber-500/20 rounded-xl flex items-center justify-center">
                <i class="bi bi-play-btn text-amber-600"></i>
            </div>
        </div>
        <p class="text-lg font-bold text-gray-900 dark:text-white truncate"><?= !empty($currentEvent) ? htmlspecialchars($currentEvent['title']) : 'Gak ada acara hari ini' ?></p>
        <p class="text-sm text-amber-600 dark:text-amber-200 mt-2"><?= !empty($currentEvent) ? date('d M Y', strtotime($currentEvent['event_date'])) : '' ?></p>
    </div>
    <div class="bg-indigo-50 dark:bg-indigo-500/10 rounded-2xl p-6 border border-indigo-100 dark:border-indigo-500/20 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm font-medium text-indigo-600 dark:text-indigo-200">Acara Mendatang</p>
            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-500/20 rounded-xl flex items-center justify-center">
                <i class="bi bi-calendar2-heart text-indigo-600"></i>
            </div>
        </div>
        <p class="text-lg font-bold text-gray-900 dark:text-white truncate"><?= !empty($upcomingEvent) ? htmlspecialchars($upcomingEvent['title']) : 'Gak ada acara bulan ini' ?></p>
        <p class="text-sm text-indigo-600 dark:text-indigo-200 mt-2"><?= !empty($upcomingEvent) ? date('d M Y', strtotime($upcomingEvent['event_date'])) : '' ?></p>
    </div>
</div>

<!-- Success Message -->
<?php if (isset($_SESSION['success_msg'])): ?>
    <div class="bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 p-4 rounded-xl mb-6 border border-green-100 dark:border-green-500/20 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3"><i class="bi bi-check-circle-fill"></i><?= htmlspecialchars($_SESSION['success_msg']) ?></div>
        <button onclick="this.parentElement.remove()"><i class="bi bi-x-lg"></i></button>
    </div>
    <?php unset($_SESSION['success_msg']); ?>
<?php endif; ?>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
