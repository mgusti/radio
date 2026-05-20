<section class="p-4 py-10" data-aos="fade-down" data-aos-duration="1000">
    <div class="w-full max-w-7xl mx-auto text-center">
        <span class="px-4 py-1.5 rounded-full bg-black/5 dark:bg-white/5 border border-black/10 dark:border-white/10 text-xs font-bold uppercase tracking-widest text-gray-600 dark:text-gray-400 inline-block mb-4">
            Tentang Kami
        </span>
        <h1 class="text-4xl lg:text-6xl font-black mb-4 text-gray-900 dark:text-white tracking-tight">
            Profil <?= htmlspecialchars($station_name) ?>
        </h1>
        <p class="text-gray-500 dark:text-gray-400 text-lg md:text-xl max-w-2xl mx-auto font-medium">
            "<?= htmlspecialchars($tagline) ?>"
        </p>
    </div>
</section>

<!-- About Section -->
<section class="p-4 py-10" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
    <div class="w-full max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center bg-gray-50 dark:bg-[#121212] border border-gray-100 dark:border-white/5 rounded-3xl p-6 md:p-12 shadow-xl">
            <div class="lg:col-span-7 space-y-6">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">
                    Suara Komunitas, Kebanggaan Muaro Jambi
                </h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-lg">
                    <?= htmlspecialchars($description) ?>
                </p>
                <div class="grid grid-cols-2 gap-6 pt-4">
                    <div class="border-l-4 border-black dark:border-white pl-4">
                        <h4 class="text-2xl font-black text-gray-900 dark:text-white">24/7</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider">Jam Siaran Nonstop</p>
                    </div>
                    <div class="border-l-4 border-black dark:border-white pl-4">
                        <h4 class="text-2xl font-black text-gray-900 dark:text-white">100%</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider">Musik & Informasi Lokal</p>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-5 relative">
                <div class="relative w-full h-[320px] rounded-2xl overflow-hidden shadow-2xl border border-gray-200 dark:border-white/10 group">
                    <img src="https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?auto=format&fit=crop&q=80&w=800" alt="Radio Broadcast Studio" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 text-white">
                        <p class="text-xs font-bold uppercase tracking-widest opacity-80">Studio Utama</p>
                        <h3 class="text-xl font-bold">GibelFm On Air</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="p-4 py-16" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
    <div class="w-full max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Vision -->
            <div class="flex flex-col bg-white dark:bg-[#121212] border border-gray-200 dark:border-white/10 rounded-2xl p-8 shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-black dark:bg-white text-white dark:text-black flex items-center justify-center mb-6 shadow-md">
                    <i class="bi bi-eye-fill text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Visi</h3>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-lg flex-1">
                    "<?= htmlspecialchars($vision) ?>"
                </p>
            </div>

            <!-- Mission -->
            <div class="flex flex-col bg-white dark:bg-[#121212] border border-gray-200 dark:border-white/10 rounded-2xl p-8 shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-black dark:bg-white text-white dark:text-black flex items-center justify-center mb-6 shadow-md">
                    <i class="bi bi-bullseye text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Misi</h3>
                <ul class="space-y-4 text-gray-600 dark:text-gray-300 flex-1">
                    <?php foreach ($missions as $mission): ?>
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-black/5 dark:bg-white/5 text-black dark:text-white flex items-center justify-center mt-1">
                                <i class="bi bi-check2 text-sm font-bold"></i>
                            </span>
                            <span class="text-base leading-relaxed"><?= htmlspecialchars($mission) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Crew Section -->
<section class="p-4 py-16 bg-gray-50 dark:bg-[#0c0c0c] border-y border-gray-100 dark:border-white/5" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
    <div class="w-full max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-white mb-3">Tim Kami</h2>
            <p class="text-gray-500 dark:text-gray-400 text-lg">Orang-orang hebat di balik layar GibelFm.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($crew as $member): ?>
                <div class="flex flex-col items-center bg-white dark:bg-[#121212] border border-gray-200 dark:border-white/10 rounded-2xl p-6 shadow-lg hover:-translate-y-2 hover:shadow-xl transition-all duration-300 group">
                    <div class="w-32 h-32 rounded-full overflow-hidden mb-6 border-4 border-gray-100 dark:border-white/10 relative shadow-inner">
                        <img src="<?= htmlspecialchars($member['avatar']) ?>" alt="<?= htmlspecialchars($member['name']) ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1 group-hover:text-gray-600 dark:group-hover:text-gray-400 transition-colors">
                        <?= htmlspecialchars($member['name']) ?>
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider mb-4">
                        <?= htmlspecialchars($member['role']) ?>
                    </p>
                    <div class="flex gap-3 mt-2">
                        <?php if (!empty($member['social']['facebook'])): ?>
                            <a href="<?= htmlspecialchars($member['social']['facebook']) ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-colors shadow-sm">
                                <i class="fab fa-facebook-f text-sm"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($member['social']['instagram'])): ?>
                            <a href="<?= htmlspecialchars($member['social']['instagram']) ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-colors shadow-sm">
                                <i class="fab fa-instagram text-sm"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($member['social']['tiktok'])): ?>
                            <a href="<?= htmlspecialchars($member['social']['tiktok']) ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-colors shadow-sm">
                                <i class="fab fa-tiktok text-sm"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
