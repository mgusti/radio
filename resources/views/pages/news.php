<section class="p-4 py-10" data-aos="fade-down" data-aos-duration="1000">
    <div class="w-full max-w-7xl mx-auto text-center">
        <h1 class="text-4xl lg:text-6xl font-bold mb-4 text-gray-900 dark:text-white">Berita Terbaru</h1>
        <p class="text-gray-500 dark:text-gray-400 text-lg">Dapatkan informasi terkini dan berita terbaru dari kami.</p>
    </div>
</section>

<section class="p-4 py-10" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
    <div class="w-full max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if(!empty($newsItems)): ?>
                <?php foreach($newsItems as $news): ?>
                    <article class="flex flex-col bg-white dark:bg-[#121212] border border-gray-200 dark:border-white/10 rounded-2xl shadow-xl overflow-hidden hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 group">
                        <div class="relative h-[250px] overflow-hidden bg-gray-100 dark:bg-white/5 flex items-center justify-center">
                            <?php if (!empty($news['image_url'])): ?>
                                <img src="<?= htmlspecialchars($news['image_url']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                            <?php else: ?>
                                <div class="flex flex-col items-center justify-center text-gray-300 dark:text-gray-700">
                                    <i class="bi bi-image text-5xl"></i>
                                    <span class="text-xs font-black uppercase tracking-widest mt-2">Tidak Ada Gambar</span>
                                </div>
                            <?php endif; ?>
                            <div class="absolute top-4 right-4 bg-black bg-opacity-70 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-semibold tracking-wide">
                                <?= date('M d, Y', strtotime($news['date'] ?? $news['created_at'])) ?>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-xl font-bold mb-3 leading-tight text-gray-900 dark:text-white"><?= htmlspecialchars($news['title']) ?></h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6 flex-1"><?= htmlspecialchars($news['excerpt']) ?></p>
                            <div class="flex items-center justify-between mt-auto">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    <i class="bi bi-person-circle mr-1"></i> <?= htmlspecialchars($news['author'] ?? 'Admin') ?>
                                </p>
                                <a href="/radio/news/view?id=<?= $news['id'] ?>" class="text-black dark:text-white font-bold text-sm uppercase tracking-wider flex items-center gap-2 group/link">
                                    Selengkapnya <i class="bi bi-arrow-right transform group-hover/link:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-20 text-gray-500 dark:text-gray-400">
                    <p class="text-xl">Belum ada berita saat ini.</p>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="mt-16 flex justify-center items-center gap-3">
                <?php if ($currentPage > 1): ?>
                    <a href="?page=<?= $currentPage - 1 ?>" 
                       class="w-12 h-12 flex items-center justify-center rounded-xl bg-white dark:bg-[#121212] border border-gray-200 dark:border-white/10 text-gray-600 dark:text-gray-400 hover:bg-black dark:hover:bg-white hover:text-white dark:hover:text-black transition-all duration-300 shadow-sm hover:shadow-lg">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                <?php endif; ?>

                <div class="flex items-center gap-2 bg-white dark:bg-[#121212] p-1 rounded-2xl border border-gray-200 dark:border-white/10 shadow-sm">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>" 
                           class="w-10 h-10 flex items-center justify-center rounded-xl font-bold transition-all duration-300 <?= $i === $currentPage ? 'bg-black dark:bg-white text-white dark:text-black shadow-md' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=<?= $currentPage + 1 ?>" 
                       class="w-12 h-12 flex items-center justify-center rounded-xl bg-white dark:bg-[#121212] border border-gray-200 dark:border-white/10 text-gray-600 dark:text-gray-400 hover:bg-black dark:hover:bg-white hover:text-white dark:hover:text-black transition-all duration-300 shadow-sm hover:shadow-lg">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
