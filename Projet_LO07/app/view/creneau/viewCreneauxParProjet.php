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

  <h2>Mes créneaux pour ce projet</h2>

  <?php if (empty($creneaux)): ?>
    <p>Aucun créneau pour ce projet.</p>
  <?php else: ?>
    <ul class="list-group w-50">
      <?php foreach ($creneaux as $c): ?>
        <li class="list-group-item"><?= htmlspecialchars($c['creneau']) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
