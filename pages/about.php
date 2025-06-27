<?php
$title = "About Bonsai";
$description = "Learn more about the Bonsai framework and what makes it lightweight and flexible.";
$body_class = "bg-white text-gray-800";
$use_layout = true;

ob_start();
?>
<h1 class="text-3xl font-bold mb-4">About Bonsai</h1>
<p>Bonsai is a PHP-based framework built for portability, simplicity, and clean design.</p>
<?php
$content = ob_get_clean();
