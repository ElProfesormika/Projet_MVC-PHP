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

  <h2>Mes créneaux</h2>

  <?php if (empty($creneaux)): ?>
    <p>Vous n'avez aucun créneau programmé.</p>
  <?php else: ?>
    <table class="table table-bordered">
      <thead class="table-success">
        <tr>
          <th>Projet</th>
          <th>Date et heure</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($creneaux as $c): ?>
          <tr>
            <td><?= htmlspecialchars($c['projet']) ?></td>
            <td><?= htmlspecialchars($c['creneau']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
