<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title ?? 'GibelFm - The Spirit of Muaro Jambi') ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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

<body>  
  <header class="p-4 pb-20">
    <div class="w-full max-w-7xl mx-auto">
      <div class="flex justify-between gap-8 items-center">
        <div>
          <a href="<?= rtrim($baseUrl, '/') ?>/" class=" font-bold text-4xl"><span class="border-b-4 border-black">Gibel</span>Fm</a>
        </div>
        <div class="flex items-center gap-8">
          <nav class="hidden lg:flex gap-8">
            <?php $isNewsPage = strpos($_SERVER['REQUEST_URI'], 'news') !== false; ?>
            <a href="<?= rtrim($baseUrl, '/') ?>/" class="hover:underline">Home</a>
            <a href="<?= rtrim($baseUrl, '/') ?>/news" class="hover:underline">News</a>
            <?php if (!$isNewsPage): ?>
            <a href="#contact" class="hover:underline">Contact us</a>
            <?php endif; ?>
          </nav>
          <span class="hidden lg:block">|</span>
          <div class="flex gap-4 text items-center">
            <a href="">
              <i class="flex items-center justify-center bg-black text-white rounded-full w-[35px] h-[35px] bi bi-search"></i>
            </a>
            <a href="">
              <i class="flex items-center justify-center bg-black text-white rounded-full w-[35px] h-[35px] bi bi-person"></i>
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

  <footer class="p-4 pb-10 pt-20" id="contact">
    <div class="gap-8 flex justify-between mx-auto max-w-7xl w-full">
      <div class="flex justify-center space-x-6">
        <span class="inline-flex justify-center w-full gap-3 lg:ml-auto md:justify-start md:w-auto">
          <a class="size-6 transition fill-black hover:text-blue-500">
            <span class="sr-only"> twitter </span>
            <i class="bi bi-twitter-x"></i>
          </a>
          <a class="size-6 transition fill-black hover:text-blue-500">
            <span class="sr-only"> Instagram </span>
            <i class="bi bi-instagram"></i>
          </a>
        </span>
      </div>
      <p>&copy; <?= date('Y') ?> GibelFm • The Spirit of Muaro Jambi</p>
      <div>
        <span class="text-sm font-medium text-gray-500">
          Copyright © <span><?= date('Y') ?></span>
        </span>
      </div>
    </div>
  </footer>

  <script>
    AOS.init();
  </script>
  <script src="<?= $baseUrl ?>js/script.js"></script>
</body>
</html>
