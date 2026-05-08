<?php
$activeSection = 'news-create';
require_once __DIR__ . '/layout_header.php';
?>

<div class="max-w-3xl">
    <div class="mb-8">
        <a href="/radio/<?= ADMIN_SLUG ?>" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors mb-4">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create News</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Publish a new article to the site.</p>
    </div>

    <form action="/radio/<?= ADMIN_SLUG ?>/news/create" method="POST" enctype="multipart/form-data"
          class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 p-8 flex flex-col gap-6">

        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" required
                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Excerpt <span class="text-red-500">*</span></label>
            <textarea name="excerpt" rows="2" required
                      class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white resize-none"></textarea>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Display Date <span class="text-red-500">*</span></label>
            <input type="date" name="date" required value="<?= date('Y-m-d') ?>"
                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Image URL</label>
                <input type="url" name="image_url" placeholder="https://..."
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white text-sm">
                <p class="text-[10px] text-gray-400 mt-1 italic">Optional if uploading a file</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Upload Image File</label>
                <input type="file" name="image_file" accept="image/*"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white text-sm file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-black dark:file:bg-white file:text-white dark:file:text-black hover:file:bg-gray-800 cursor-pointer">
                <div class="flex justify-between mt-1 px-1">
                    <span class="text-[10px] text-gray-400 italic">Max size: 2MB</span>
                    <span class="text-[10px] text-blue-500 font-bold">Recommended: 1200×800px</span>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Full Content <span class="text-red-500">*</span></label>
            <textarea name="content" rows="8" required
                      class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white resize-y"></textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-black dark:bg-white dark:text-black text-white px-8 py-3 rounded-xl font-semibold hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-sm flex items-center gap-2">
                <i class="bi bi-send"></i> Publish News
            </button>
            <a href="/radio/<?= ADMIN_SLUG ?>" class="px-8 py-3 rounded-xl font-semibold border border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
