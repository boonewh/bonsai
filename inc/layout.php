<?php
// Defaults if not set in the page
$title = $title ?? 'Bonsai Framework';
$description = $description ?? 'A lightweight, modern PHP site kit.';
$body_class = $body_class ?? 'bg-gray-100 text-gray-900';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($title) ?></title>
  <meta name="description" content="<?= htmlspecialchars($description) ?>" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="<?= $body_class ?>">
  <header class="bg-white shadow p-4">
    <nav class="flex space-x-4">
      <a href="/" class="font-semibold text-blue-700 hover:underline">Home</a>
      <a href="/about" class="font-semibold text-blue-700 hover:underline">About</a>
    </nav>
  </header>

  <?php require_once __DIR__ . '/functions.php'; ?>

  <main class="p-6 max-w-4xl mx-auto">
    <?= wrap($content, $wrap_mode ?? '') ?>
  </main>

  <footer class="bg-white shadow p-4 mt-8 text-center text-sm text-gray-500">
    &copy; <?= date('Y') ?> Bonsai Framework
  </footer>
</body>
</html>
