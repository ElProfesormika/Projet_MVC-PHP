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

  <h2>Créneaux disponibles</h2>

  <?php if (empty($creneaux)): ?>
    <p>Aucun créneau disponible.</p>
  <?php else: ?>
    <table class="table table-bordered">
      <thead class="table-success">
        <tr>
          <th>Projet</th>
          <th>Date et Heure</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($creneaux as $c): ?>
          <tr>
            <td><?= htmlspecialchars($c['projet']) ?></td>
            <td><?= htmlspecialchars($c['creneau']) ?></td>
            <td>
              <form method="post" action="router1.php?action=etudiantValiderRdv">
                <input type="hidden" name="id_creneau" value="<?= $c['id'] ?>">
                <button class="btn btn-primary btn-sm">Réserver</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
