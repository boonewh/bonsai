<?php
$use_layout = true;
$title = "Welcome to Bonsai";
$wrap_mode = "card"; // can be '', 'card', or 'sidebar'

ob_start();
?>
<h1 class="text-2xl font-bold mb-4">Welcome to Bonsai!</h1>
<p>This is your lightweight, scalable, shared-hosting-friendly PHP starter kit.</p>
<?php
$content = ob_get_clean();
