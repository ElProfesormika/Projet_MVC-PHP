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

  <h2>Liste des examinateurs</h2>

  <?php if (empty($examinateurs)): ?>
    <p>Aucun examinateur trouvé.</p>
  <?php else: ?>
    <table class="table table-bordered">
      <thead class="table-success">
        <tr>
          <th>Nom</th>
          <th>Prénom</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($examinateurs as $exam): ?>
          <tr>
            <td><?= htmlspecialchars($exam->getNom()) ?></td>
            <td><?= htmlspecialchars($exam->getPrenom()) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
