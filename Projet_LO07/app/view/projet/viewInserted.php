<?php
$root = dirname(__DIR__, 3);  
require($root . '/app/view/fragment/fragmentCaveHeader.html');
?>

<div class="container mt-5">
  <?php
    include $root . '/app/view/fragment/fragmentCaveMenu.html';
    include $root . '/app/view/fragment/fragmentCaveJumbotron.html';
    include $root . '/app/view/fragment/fragmentCaveFlash.html';
  ?>
  <div class="alert alert-success mt-3"><?= $_SESSION['flash'] ?? "Insertion réalisée." ?></div>
</div>
<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
