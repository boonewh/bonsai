<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'Bonsai Framework' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 text-gray-900">
  <nav class="p-4 bg-white shadow">
    <?php foreach (bonsai_config('nav', []) as $label => $url): ?>
      <a href="<?= bonsai_url($url) ?>" class="mr-4"><?= $label ?></a>
    <?php endforeach; ?>
  </nav>
  <main class="p-6">
