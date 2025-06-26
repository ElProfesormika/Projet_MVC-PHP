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
  <h2>🗓️ Planning de soutenance</h2>

  <?php if (empty($rdvs)): ?>
    <p>Aucun rendez-vous enregistré pour ce projet.</p>
  <?php else: ?>
    <table class="table table-bordered">
      <thead class="table-success">
        <tr>
          <th>Date & Heure</th>
          <th>Étudiant</th>
          <th>Examinateur</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rdvs as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['date_heure']) ?></td>
            <td><?= htmlspecialchars($r['etu_nom']) . ' ' . htmlspecialchars($r['etu_prenom']) ?></td>
            <td><?= htmlspecialchars($r['exam_nom']) . ' ' . htmlspecialchars($r['exam_prenom']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
