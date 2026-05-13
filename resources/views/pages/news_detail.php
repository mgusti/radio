<article class="max-w-4xl mx-auto p-4 py-16" data-aos="fade-up" data-aos-duration="1000">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-8">
        <a href="/radio/" class="hover:text-black dark:hover:text-white transition-colors">Home</a>
        <i class="bi bi-chevron-right text-[10px]"></i>
        <a href="/radio/news" class="hover:text-black dark:hover:text-white transition-colors">News</a>
        <i class="bi bi-chevron-right text-[10px]"></i>
        <span class="text-black dark:text-white font-medium truncate"><?= htmlspecialchars($news['title']) ?></span>
    </nav>

    <!-- Header Section -->
    <header class="mb-12">
        <div class="flex items-center gap-4 mb-6">
            <span class="bg-black dark:bg-white text-white dark:text-black px-3 py-1 rounded-full text-xs font-bold tracking-widest uppercase transition-colors">
                Trending
            </span>
            <span class="text-gray-400 text-sm flex items-center gap-2">
                <i class="bi bi-calendar3"></i>
                <?= date('M d, Y', strtotime($news['date'] ?? $news['created_at'])) ?>
            </span>
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-8 text-gray-900 dark:text-white">
            <?= htmlspecialchars($news['title']) ?>
        </h1>
        <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-white/5 rounded-2xl border border-gray-100 dark:border-white/10 transition-colors">
            <div class="w-12 h-12 bg-black dark:bg-white rounded-full flex items-center justify-center text-white dark:text-black font-bold text-xl transition-colors">
                <?= strtoupper(substr($news['author'] ?? 'A', 0, 1)) ?>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Published by</p>
                <p class="text-black dark:text-white font-bold transition-colors"><?= htmlspecialchars($news['author'] ?? 'Admin') ?></p>
            </div>
        </div>
    </header>

    <!-- Featured Image -->
    <div class="relative h-[400px] md:h-[500px] rounded-3xl overflow-hidden shadow-2xl mb-16 group bg-gray-50 dark:bg-white/5 flex items-center justify-center border border-gray-100 dark:border-white/10 transition-colors">
        <?php if (!empty($news['image_url'])): ?>
            <img src="<?= htmlspecialchars($news['image_url']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" 
                 class="w-full h-full object-cover transform transition-transform duration-1000">
        <?php else: ?>
            <div class="flex flex-col items-center justify-center text-gray-200 dark:text-gray-800">
                <i class="bi bi-image text-9xl"></i>
                <span class="text-xl font-black uppercase tracking-[0.3em] mt-4">No Image Available</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Content Section -->
    <div class="prose prose-lg max-w-none">
        <div class="text-xl font-medium text-gray-600 dark:text-gray-400 mb-10 leading-relaxed border-l-4 border-black dark:border-white pl-8 italic transition-colors">
            <?= htmlspecialchars($news['excerpt']) ?>
        </div>
        
        <div class="text-gray-800 dark:text-gray-300 leading-relaxed space-y-6 text-lg transition-colors">
            <?= nl2br(htmlspecialchars($news['content'])) ?>
        </div>
    </div>

    <!-- Footer / Share -->
    <footer class="mt-16 pt-8 border-t border-gray-200 dark:border-white/10 transition-colors">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-4">
                <span class="font-bold text-gray-900 dark:text-white">Share this story:</span>
                <div class="flex gap-2">
                    <a href="https://www.facebook.com/gibelfm/" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full border border-gray-200 dark:border-white/10 flex items-center justify-center hover:bg-black dark:hover:bg-white hover:text-white dark:hover:text-black transition-all">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.tiktok.com/@djun_23?_r=1&_t=ZS-969M0HYrlSi" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full border border-gray-200 dark:border-white/10 flex items-center justify-center hover:bg-black dark:hover:bg-white hover:text-white dark:hover:text-black transition-all">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    <!-- <a href="https://x.com/Junaedi39863173" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full border border-gray-200 dark:border-white/10 flex items-center justify-center hover:bg-black dark:hover:bg-white hover:text-white dark:hover:text-black transition-all">
                        <i class="fab fa-x-twitter"></i>
                    </a> -->
                    <a href="https://www.instagram.com/radiogibelfmnews/" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full border border-gray-200 dark:border-white/10 flex items-center justify-center hover:bg-black dark:hover:bg-white hover:text-white dark:hover:text-black transition-all">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <button onclick="navigator.clipboard.writeText(window.location.href)" title="Copy story link" class="w-10 h-10 rounded-full border border-gray-200 dark:border-white/10 flex items-center justify-center hover:bg-black dark:hover:bg-white hover:text-white dark:hover:text-black transition-all">
                        <i class="bi bi-link-45deg text-xl"></i>
                    </button>
                </div>
            </div>
            <a href="/radio/news" class="bg-black dark:bg-white text-white dark:text-black px-8 py-3 rounded-full font-bold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all transform hover:-translate-x-2 flex items-center gap-2 shadow-lg">
                <i class="bi bi-arrow-left"></i> Back to News
            </a>
        </div>
    </footer>
</article>
