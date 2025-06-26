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

  <h2> Mes rendez-vous de soutenance</h2>

  <?php if (empty($rdvs)): ?>
    <p>Vous n'avez encore aucun rendez-vous de soutenance.</p>
  <?php else: ?>
    <table class="table table-bordered">
      <thead class="table-success">
        <tr>
          <th>Projet</th>
          <th>Date et Heure</th>
          <th>Examinateur</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rdvs as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['projet']) ?></td>
            <td><?= htmlspecialchars($r['creneau']) ?></td>
            <td><?= htmlspecialchars($r['exam_nom']) ?> <?= htmlspecialchars($r['exam_prenom']) ?></td>
            <td>
              <form method="post" action="router1.php?action=etudiantAnnulerRdvById">
                <input type="hidden" name="id_rdv" value="<?= $r['id'] ?>">
                <button class="btn btn-danger btn-sm"> Annuler</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>