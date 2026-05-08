<section class="p-4 py-16" data-aos="fade-up" data-aos-duration="1000">
    <div class="w-full max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div>
                <h1 class="text-4xl md:text-6xl font-bold mb-4 text-gray-900 dark:text-white">Program Calendar</h1>
                <p class="text-gray-500 dark:text-gray-400 text-lg">Stay tuned with our upcoming shows and community events.</p>
            </div>
            <div class="flex items-center gap-4 bg-gray-50 dark:bg-white/5 p-2 rounded-2xl border border-gray-100 dark:border-white/10 transition-colors">
                <button class="w-12 h-12 flex items-center justify-center rounded-xl hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-all">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <span class="text-xl font-bold px-4 text-gray-900 dark:text-white"><?= date('F Y') ?></span>
                <button class="w-12 h-12 flex items-center justify-center rounded-xl hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-all">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="bg-white dark:bg-[#121212] rounded-3xl shadow-2xl overflow-hidden border border-gray-100 dark:border-white/10 transition-colors">
            <!-- Days Header -->
            <div class="grid grid-cols-7 bg-black dark:bg-white text-white dark:text-black font-bold uppercase tracking-widest text-xs py-4 text-center">
                <div>Sun</div>
                <div>Mon</div>
                <div>Tue</div>
                <div>Wed</div>
                <div>Thu</div>
                <div>Fri</div>
                <div>Sat</div>
            </div>

            <!-- Calendar Days -->
            <div class="grid grid-cols-7 border-t border-gray-100 dark:border-white/10">
                <?php
                $year = date('Y');
                $month = date('m');
                $firstDay = date('w', strtotime("$year-$month-01"));
                $daysInMonth = date('t', strtotime("$year-$month-01"));
                
                // Empty slots for previous month
                for ($i = 0; $i < $firstDay; $i++): ?>
                    <div class="h-32 md:h-40 border-r border-b border-gray-100 dark:border-white/10 bg-gray-50/50 dark:bg-white/[0.02]"></div>
                <?php endfor;

                // Actual days
                for ($day = 1; $day <= $daysInMonth; $day++): 
                    $currentDate = sprintf('%04d-%02d-%02d', $year, $month, $day);
                    $isToday = $currentDate === date('Y-m-d');
                    $isUpcomingDay = isset($upcomingDate) && $currentDate === $upcomingDate;
                    $hasEvents = isset($events[$currentDate]);

                    $cellClasses = 'h-32 md:h-40 border-r border-b border-gray-100 dark:border-white/10 p-2 md:p-4 group transition-colors relative';
                    if ($isToday) {
                        $cellClasses .= ' bg-amber-50 dark:bg-amber-900/10 hover:bg-amber-100 dark:hover:bg-amber-900/20';
                    } elseif ($isUpcomingDay) {
                        $cellClasses .= ' bg-emerald-50 dark:bg-emerald-900/10 hover:bg-emerald-100 dark:hover:bg-emerald-900/20';
                    } else {
                        $cellClasses .= ' hover:bg-gray-50 dark:hover:bg-white/[0.03]';
                    }

                    $dayClasses = $isToday
                        ? 'bg-black dark:bg-white text-white dark:text-black w-8 h-8 md:w-10 md:h-10 flex items-center justify-center rounded-full'
                        : ($isUpcomingDay
                            ? 'text-emerald-700 dark:text-emerald-300'
                            : 'text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white');
                ?>
                    <div class="<?= $cellClasses ?>">
                        <span class="text-lg md:text-xl font-bold <?= $dayClasses ?> transition-colors">
                            <?= $day ?>
                        </span>
                        <?php if ($isToday): ?>
                            <span class="absolute top-3 right-3 w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center text-[10px] shadow-lg">
                                <i class="bi bi-pin-angle-fill"></i>
                            </span>
                        <?php endif; ?>
                        
                        <div class="mt-2 space-y-1">
                            <?php if ($hasEvents): ?>
                                <?php foreach ($events[$currentDate] as $event): ?>
                                    <?php
                                        $itemClasses = $event['type'] === 'program'
                                            ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400'
                                            : 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400';

                                        if ($isToday) {
                                            $itemClasses = 'bg-amber-100 text-amber-900 dark:bg-amber-900/30 dark:text-amber-200';
                                        } elseif ($isUpcomingDay) {
                                            $itemClasses = 'bg-emerald-100 text-emerald-900 dark:bg-emerald-900/30 dark:text-emerald-200';
                                        }
                                    ?>
                                    <div class="text-[10px] md:text-xs p-1.5 rounded-lg font-bold truncate transition-all cursor-pointer <?= $itemClasses ?> hover:scale-105">
                                        <i class="bi <?= $event['type'] === 'program' ? 'bi-broadcast' : 'bi-calendar-event' ?> mr-1"></i>
                                        <?= htmlspecialchars($event['title']) ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endfor;

                // Empty slots for next month
                $totalCells = $firstDay + $daysInMonth;
                $remainingCells = (7 - ($totalCells % 7)) % 7;
                for ($i = 0; $i < $remainingCells; $i++): ?>
                    <div class="h-32 md:h-40 border-r border-b border-gray-100 dark:border-white/10 bg-gray-50/50 dark:bg-white/[0.02]"></div>
                <?php endfor;
                ?>
            </div>
        </div>

        <!-- Legend -->
        <div class="mt-8 flex flex-wrap gap-6 justify-center">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Radio Programs</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-purple-500"></span>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Community Events</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Current Event</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Upcoming Event</span>
            </div>
        </div>
    </div>
</section>
