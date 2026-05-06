<section class="p-4 py-10" data-aos="fade-down" data-aos-duration="1000">
    <div class="w-full max-w-7xl mx-auto text-center">
        <h1 class="text-4xl lg:text-6xl font-bold mb-4">Latest Updates</h1>
        <p class="text-gray-500 text-lg">Stay informed with the newest trends and stories.</p>
    </div>
</section>

<section class="p-4 py-10" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
    <div class="w-full max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if(!empty($newsItems)): ?>
                <?php foreach($newsItems as $news): ?>
                    <article class="flex flex-col bg-white border border-gray-200 rounded-2xl shadow-xl overflow-hidden hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 group">
                        <div class="relative h-[250px] overflow-hidden">
                            <img src="<?= htmlspecialchars($news['image_url']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-4 right-4 bg-black bg-opacity-70 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-semibold tracking-wide">
                                <?= date('M d, Y', strtotime($news['date'] ?? $news['created_at'])) ?>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-xl font-bold mb-3 leading-tight"><?= htmlspecialchars($news['title']) ?></h3>
                            <p class="text-gray-600 mb-6 flex-1"><?= htmlspecialchars($news['excerpt']) ?></p>
                            <a href="#" class="inline-flex items-center gap-2 text-blue-600 font-semibold hover:text-blue-800 transition-colors mt-auto group/link">
                                Read More <i class="bi bi-arrow-right transform group-hover/link:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-20 text-gray-500">
                    <p class="text-xl">No news available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
