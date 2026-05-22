<?php
$activeSection = 'profile';
require_once __DIR__ . '/layout_header.php';
?>

<div class="max-w-5xl">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Profil Stasiun</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola data profil stasiun radio, visi, misi, dan anggota kru stasiun.</p>
    </div>

    <?php if (isset($_SESSION['success_msg'])): ?>
        <div class="bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 p-4 rounded-xl mb-6 border border-green-100 dark:border-green-500/20 flex items-center justify-between gap-3 animate-fade-in">
            <div class="flex items-center gap-3"><i class="bi bi-check-circle-fill"></i><?= htmlspecialchars($_SESSION['success_msg']) ?></div>
            <button onclick="this.parentElement.remove()"><i class="bi bi-x-lg"></i></button>
        </div>
        <?php unset($_SESSION['success_msg']); ?>
    <?php endif; ?>

    <form action="/<?= ADMIN_SLUG ?>/profile" method="POST" class="flex flex-col gap-8">
        
        <!-- General Information Card -->
        <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 p-8 flex flex-col gap-6">
            <h3 class="text-lg font-bold flex items-center gap-2 border-b border-gray-100 dark:border-white/5 pb-4 text-gray-900 dark:text-white">
                <i class="bi bi-info-circle text-blue-500"></i> Informasi Umum Stasiun
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Stasiun <span class="text-red-500">*</span></label>
                    <input type="text" name="station_name" required value="<?= htmlspecialchars($station_name) ?>"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tagline <span class="text-red-500">*</span></label>
                    <input type="text" name="tagline" required value="<?= htmlspecialchars($tagline) ?>"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Deskripsi Stasiun / Tentang Kami <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required
                          class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white resize-y"><?= htmlspecialchars($description) ?></textarea>
            </div>
        </div>

        <!-- Vision and Mission Card -->
        <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 p-8 flex flex-col gap-6">
            <h3 class="text-lg font-bold flex items-center gap-2 border-b border-gray-100 dark:border-white/5 pb-4 text-gray-900 dark:text-white">
                <i class="bi bi-eye text-purple-500"></i> Visi & Misi
            </h3>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Visi Stasiun <span class="text-red-500">*</span></label>
                <textarea name="vision" rows="3" required
                          class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white resize-y"><?= htmlspecialchars($vision) ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Misi Stasiun <span class="text-gray-400 font-normal text-xs">(Tulis satu misi per baris)</span></label>
                <textarea name="missions" rows="6" required placeholder="Contoh:&#10;Misi pertama kami...&#10;Misi kedua kami..."
                          class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white resize-y font-mono text-sm"><?= htmlspecialchars($missions_text) ?></textarea>
            </div>
        </div>

        <!-- Crew Management Card -->
        <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-sm border border-gray-100 dark:border-white/5 p-8 flex flex-col gap-6">
            <div class="flex justify-between items-center border-b border-gray-100 dark:border-white/5 pb-4">
                <h3 class="text-lg font-bold flex items-center gap-2 text-gray-900 dark:text-white">
                    <i class="bi bi-people text-emerald-500"></i> Anggota Kru & Penyiar
                </h3>
                <button type="button" onclick="addCrewMember()" 
                        class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors flex items-center gap-1.5 shadow-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Kru
                </button>
            </div>

            <div id="crew-container" class="flex flex-col gap-6 divide-y divide-gray-100 dark:divide-white/5">
                <?php foreach ($crew as $index => $member): ?>
                    <div class="crew-item pt-6 first:pt-0 flex flex-col gap-4 relative" data-index="<?= $index ?>">
                        <div class="absolute top-6 first:top-0 right-0">
                            <button type="button" onclick="removeCrewMember(this)" 
                                    class="text-red-500 hover:text-red-700 transition-colors text-sm flex items-center gap-1">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Nama Kru <span class="text-red-500">*</span></label>
                                <input type="text" name="crew_name[]" required value="<?= htmlspecialchars($member['name'] ?? '') ?>"
                                       class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Jabatan / Peran <span class="text-red-500">*</span></label>
                                <input type="text" name="crew_role[]" required value="<?= htmlspecialchars($member['role'] ?? '') ?>"
                                       class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">URL Foto / Avatar</label>
                                <input type="url" name="crew_avatar[]" value="<?= htmlspecialchars($member['avatar'] ?? '') ?>" placeholder="https://..."
                                       class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white text-sm font-mono">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Link Instagram</label>
                                <div class="flex items-center rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 overflow-hidden focus-within:ring-2 focus-within:ring-black dark:focus-within:ring-white transition-all">
                                    <span class="pl-3 pr-1 text-gray-400"><i class="bi bi-instagram"></i></span>
                                    <input type="url" name="crew_ig[]" value="<?= htmlspecialchars($member['social']['instagram'] ?? '') ?>" placeholder="https://instagram.com/..."
                                           class="w-full px-2 py-2.5 bg-transparent border-none focus:outline-none text-gray-900 dark:text-white text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Link Facebook</label>
                                <div class="flex items-center rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 overflow-hidden focus-within:ring-2 focus-within:ring-black dark:focus-within:ring-white transition-all">
                                    <span class="pl-3 pr-1 text-gray-400"><i class="bi bi-facebook"></i></span>
                                    <input type="url" name="crew_fb[]" value="<?= htmlspecialchars($member['social']['facebook'] ?? '') ?>" placeholder="https://facebook.com/..."
                                           class="w-full px-2 py-2.5 bg-transparent border-none focus:outline-none text-gray-900 dark:text-white text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Link TikTok</label>
                                <div class="flex items-center rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 overflow-hidden focus-within:ring-2 focus-within:ring-black dark:focus-within:ring-white transition-all">
                                    <span class="pl-3 pr-1 text-gray-400"><i class="bi bi-tiktok"></i></span>
                                    <input type="url" name="crew_tt[]" value="<?= htmlspecialchars($member['social']['tiktok'] ?? '') ?>" placeholder="https://tiktok.com/@..."
                                           class="w-full px-2 py-2.5 bg-transparent border-none focus:outline-none text-gray-900 dark:text-white text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex gap-4 pt-2">
            <button type="submit" class="bg-black dark:bg-white dark:text-black text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-lg flex items-center gap-2">
                <i class="bi bi-cloud-arrow-up"></i> Simpan Perubahan
            </button>
            <a href="/<?= ADMIN_SLUG ?>" class="px-8 py-4 rounded-xl font-bold border border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>

<!-- Template for new crew member row -->
<template id="crew-template">
    <div class="crew-item pt-6 flex flex-col gap-4 relative">
        <div class="absolute top-6 right-0">
            <button type="button" onclick="removeCrewMember(this)" 
                    class="text-red-500 hover:text-red-700 transition-colors text-sm flex items-center gap-1">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Nama Kru <span class="text-red-500">*</span></label>
                <input type="text" name="crew_name[]" required value=""
                       class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Jabatan / Peran <span class="text-red-500">*</span></label>
                <input type="text" name="crew_role[]" required value=""
                       class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">URL Foto / Avatar</label>
                <input type="url" name="crew_avatar[]" value="" placeholder="https://..."
                       class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white text-sm font-mono">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Link Instagram</label>
                <div class="flex items-center rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 overflow-hidden focus-within:ring-2 focus-within:ring-black dark:focus-within:ring-white transition-all">
                    <span class="pl-3 pr-1 text-gray-400"><i class="bi bi-instagram"></i></span>
                    <input type="url" name="crew_ig[]" value="" placeholder="https://instagram.com/..."
                           class="w-full px-2 py-2.5 bg-transparent border-none focus:outline-none text-gray-900 dark:text-white text-sm">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Link Facebook</label>
                <div class="flex items-center rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 overflow-hidden focus-within:ring-2 focus-within:ring-black dark:focus-within:ring-white transition-all">
                    <span class="pl-3 pr-1 text-gray-400"><i class="bi bi-facebook"></i></span>
                    <input type="url" name="crew_fb[]" value="" placeholder="https://facebook.com/..."
                           class="w-full px-2 py-2.5 bg-transparent border-none focus:outline-none text-gray-900 dark:text-white text-sm">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1.5">Link TikTok</label>
                <div class="flex items-center rounded-xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 overflow-hidden focus-within:ring-2 focus-within:ring-black dark:focus-within:ring-white transition-all">
                    <span class="pl-3 pr-1 text-gray-400"><i class="bi bi-tiktok"></i></span>
                    <input type="url" name="crew_tt[]" value="" placeholder="https://tiktok.com/@..."
                           class="w-full px-2 py-2.5 bg-transparent border-none focus:outline-none text-gray-900 dark:text-white text-sm">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
function addCrewMember() {
    const container = document.getElementById('crew-container');
    const template = document.getElementById('crew-template');
    const clone = template.content.cloneNode(true);
    container.appendChild(clone);
}

function removeCrewMember(button) {
    const row = button.closest('.crew-item');
    if (document.querySelectorAll('#crew-container .crew-item').length > 1) {
        row.remove();
    } else {
        alert('Minimal harus ada 1 anggota kru stasiun!');
    }
}
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
