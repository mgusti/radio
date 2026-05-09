<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title ?? 'GibelFm - The Spirit of Muaro Jambi') ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
    }
  </script>
  <script>
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
      document.documentElement.classList.add('dark')
    } else {
      document.documentElement.classList.remove('dark')
    }
  </script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <?php
  // Determine base URL dynamically
  $baseUrl = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
  ?>
  <link rel="stylesheet" href="<?= $baseUrl ?>css/style.css">
  <style>
    body {
      font-family: "Inter", sans-serif;
    }
  </style>
</head>

<body class="bg-white dark:bg-[#0a0a0a] text-black dark:text-white transition-colors duration-300">  
  <header class="p-4 pb-12 relative z-50">
    <div class="w-full max-w-7xl mx-auto">
      <div class="flex justify-between gap-8 items-center">
        <div>
          <a href="<?= rtrim($baseUrl, '/') ?>/" class="font-bold text-3xl md:text-4xl">
            <span class="border-b-4 border-black dark:border-white transition-colors">Gibel</span>Fm
          </a>
        </div>
        
        <div class="flex items-center gap-4 lg:gap-8">
          <!-- Desktop Nav -->
          <nav class="hidden lg:flex gap-8 font-medium">
            <?php $isNewsPage = strpos($_SERVER['REQUEST_URI'], 'news') !== false; ?>
            <?php $isCalendarPage = strpos($_SERVER['REQUEST_URI'], 'calendar') !== false; ?>
            <a href="<?= rtrim($baseUrl, '/') ?>/" class="hover:text-gray-500 dark:hover:text-gray-400 transition-colors">Home</a>
            <a href="<?= rtrim($baseUrl, '/') ?>/news" class="hover:text-gray-500 dark:hover:text-gray-400 transition-colors">News</a>
            <a href="<?= rtrim($baseUrl, '/') ?>/calendar" class="hover:text-gray-500 dark:hover:text-gray-400 transition-colors">Calendar</a>
            <?php if (!$isNewsPage && !$isCalendarPage): ?>
            <a href="#contact" class="hover:text-gray-500 dark:hover:text-gray-400 transition-colors">Contact us</a>
            <?php endif; ?>
          </nav>
          
          <span class="hidden lg:block text-gray-200 dark:text-gray-800">|</span>
          
          <div class="flex gap-2 md:gap-4 items-center">
            <!-- Search Icon (Keep as is for now) -->
            <button class="flex items-center justify-center bg-black dark:bg-white text-white dark:text-black rounded-full w-[35px] h-[35px] hover:scale-105 transition-transform">
              <i class="bi bi-search"></i>
            </button>
            
            <!-- Theme Toggle (Replacing Person Icon) -->
            <button id="theme-toggle" class="flex items-center justify-center bg-black dark:bg-white text-white dark:text-black rounded-full w-[35px] h-[35px] hover:scale-105 transition-transform">
              <i class="bi bi-moon-stars-fill dark:hidden"></i>
              <i class="bi bi-sun-fill hidden dark:block"></i>
            </button>

            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-toggle" class="lg:hidden flex items-center justify-center bg-gray-100 dark:bg-white/5 text-black dark:text-white rounded-full w-[35px] h-[35px]">
              <i class="bi bi-list text-xl"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Menu Drawer -->
    <div id="mobile-menu" class="fixed inset-0 bg-white dark:bg-black z-[100] transform translate-x-full transition-transform duration-300 lg:hidden">
      <div class="p-6">
        <div class="flex justify-between items-center mb-12">
          <a href="<?= rtrim($baseUrl, '/') ?>/" class="font-bold text-3xl">
            <span class="border-b-4 border-black dark:border-white">Gibel</span>Fm
          </a>
          <button id="mobile-menu-close" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 dark:bg-white/5">
            <i class="bi bi-x-lg text-xl"></i>
          </button>
        </div>
        <nav class="flex flex-col gap-6 text-2xl font-bold">
          <a href="<?= rtrim($baseUrl, '/') ?>/" class="mobile-nav-link">Home</a>
          <a href="<?= rtrim($baseUrl, '/') ?>/news" class="mobile-nav-link">News</a>
          <a href="<?= rtrim($baseUrl, '/') ?>/calendar" class="mobile-nav-link">Calendar</a>
          <a href="<?= rtrim($baseUrl, '/') ?>/#contact" class="mobile-nav-link">Contact us</a>
        </nav>
        <div class="mt-12 pt-12 border-t border-gray-100 dark:border-white/10">
          <p class="text-sm text-gray-500 uppercase tracking-widest font-bold mb-4">Follow Us</p>
          <div class="flex gap-4">
            <a href="https://www.facebook.com/gibelfm/" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full border border-gray-200 dark:border-white/10 flex items-center justify-center text-xl hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-all">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://www.tiktok.com/@djun_23?_r=1&_t=ZS-969M0HYrlSi" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full border border-gray-200 dark:border-white/10 flex items-center justify-center text-xl hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-all">
              <i class="fab fa-tiktok"></i>
            </a>
            <a href="https://x.com/Junaedi39863173" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full border border-gray-200 dark:border-white/10 flex items-center justify-center text-xl hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-all">
              <i class="fab fa-x-twitter"></i>
            </a>
            <a href="https://www.instagram.com/radiogibelfmnews/" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full border border-gray-200 dark:border-white/10 flex items-center justify-center text-xl hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-all">
              <i class="fab fa-instagram"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <main>
      <?php 
          if (isset($viewPath)) {
              require $viewPath;
          }
      ?>
  </main>

  <footer class="p-4 pb-10 pt-20 border-t border-gray-100 dark:border-white/5" id="contact">
    <div class="gap-8 flex flex-col md:flex-row justify-between mx-auto max-w-7xl w-full">
      <div class="flex items-center space-x-6">
        <span class="inline-flex gap-3">
          <a href="https://www.facebook.com/gibelfm/" target="_blank" rel="noopener noreferrer" class="text-xl transition hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="https://www.tiktok.com/@djun_23?_r=1&_t=ZS-969M0HYrlSi" target="_blank" rel="noopener noreferrer" class="text-xl transition hover:text-black dark:text-gray-400 dark:hover:text-white">
            <i class="fab fa-tiktok"></i>
          </a>
          <a href="https://x.com/Junaedi39863173" target="_blank" rel="noopener noreferrer" class="text-xl transition hover:text-sky-500 dark:text-gray-400 dark:hover:text-white">
            <i class="fab fa-x-twitter"></i>
          </a>
          <a href="https://www.instagram.com/radiogibelfmnews/" target="_blank" rel="noopener noreferrer" class="text-xl transition hover:text-pink-500 dark:text-gray-400 dark:hover:text-white">
            <i class="fab fa-instagram"></i>
          </a>
        </span>
      </div>
      <p class="text-gray-600 dark:text-gray-400">&copy; <?= date('Y') ?> GibelFm • The Spirit of Muaro Jambi</p>
      <div class="text-sm font-medium text-gray-500 dark:text-gray-600">
        Copyright © <span><?= date('Y') ?></span>
      </div>
    </div>
  </footer>

  <script>
    AOS.init();

    // Theme Toggle Logic
    const themeToggleBtn = document.getElementById('theme-toggle');
    themeToggleBtn.addEventListener('click', function() {
      if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.theme = 'light';
      } else {
        document.documentElement.classList.add('dark');
        localStorage.theme = 'dark';
      }
    });

    // Mobile Menu Logic
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileLinks = document.querySelectorAll('.mobile-nav-link');

    mobileMenuToggle.addEventListener('click', () => {
      mobileMenu.classList.remove('translate-x-full');
    });

    mobileMenuClose.addEventListener('click', () => {
      mobileMenu.classList.add('translate-x-full');
    });

    mobileLinks.forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.add('translate-x-full');
      });
    });
  </script>
  <script src="<?= $baseUrl ?>js/script.js"></script>
</body>
</html>
