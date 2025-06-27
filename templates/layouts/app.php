<?php
// Default values
$title = $title ?? bonsai_config('name');
$description = $description ?? bonsai_config('description');
$body_class = $body_class ?? bonsai_config('layout.body_class');
$wrap_mode = $wrap_mode ?? bonsai_config('layout.wrap_mode');
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
    <?= bonsai_view('partials/header') ?>

    <main class="p-6 max-w-4xl mx-auto">
        <?= bonsai_wrap($content, $wrap_mode) ?>
    </main>

    <?= bonsai_view('partials/footer') ?>
</body>
</html>