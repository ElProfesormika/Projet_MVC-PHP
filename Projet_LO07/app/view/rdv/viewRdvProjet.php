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
  <h2>Suivi des RDV (vos projets)</h2>

  <?php if (empty($results)): ?>
    <div class="alert alert-warning">Aucun RDV pour vos projets.</div>
  <?php else: ?>
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>Projet</th>
          <th>Étudiant</th>
          <th>Date & heure</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($results as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['projet']) ?></td>
            <td><?= htmlspecialchars($r['prenom'] . ' ' . $r['nom']) ?></td>
            <td><?= htmlspecialchars($r['creneau']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
