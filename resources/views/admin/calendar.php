<?php
$activeSection = 'calendar';
require_once __DIR__ . '/layout_header.php';
?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Calendar Events</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage programs and community events shown on the calendar.</p>
    </div>
    <a href="/radio/<?= ADMIN_SLUG ?>/calendar/create" class="bg-black dark:bg-white dark:text-black text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors flex items-center gap-2 shadow-sm">
        <i class="bi bi-plus-lg"></i> Add Event
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
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 dark:bg-white/5 border-b border-gray-100 dark:border-white/5 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                <th class="py-3 px-6 font-medium">Title</th>
                <th class="py-3 px-6 font-medium">Type</th>
                <th class="py-3 px-6 font-medium">Date</th>
                <th class="py-3 px-6 font-medium">Description</th>
                <th class="py-3 px-6 font-medium text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-white/5">
            <?php if (empty($events)): ?>
                <tr><td colspan="5" class="py-10 text-center text-gray-400">No events yet. Add one!</td></tr>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.03] transition-colors group">
                        <td class="py-4 px-6 font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($event['title']) ?></td>
                        <td class="py-4 px-6">
                            <?php if ($event['type'] === 'program'): ?>
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400">
                                    <i class="bi bi-broadcast"></i> Program
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-400">
                                    <i class="bi bi-calendar-event"></i> Event
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-500"><?= date('D, M d Y', strtotime($event['event_date'])) ?></td>
                        <td class="py-4 px-6 text-sm text-gray-500 max-w-xs truncate"><?= htmlspecialchars($event['description'] ?? '—') ?></td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="/radio/<?= ADMIN_SLUG ?>/calendar/edit?id=<?= $event['id'] ?>" class="text-blue-500 hover:text-blue-700 bg-blue-50 dark:bg-blue-500/10 p-2 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-500/20 transition-colors">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="/radio/<?= ADMIN_SLUG ?>/calendar/delete" method="POST" onsubmit="return confirm('Delete this event?');" class="inline">
                                    <input type="hidden" name="id" value="<?= $event['id'] ?>">
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
