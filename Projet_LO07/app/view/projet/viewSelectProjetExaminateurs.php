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

  <h2> Sélectionnez un projet</h2>

  <form method="post" action="router1.php?action=examinateursParProjet" class="w-50">
    <div class="mb-3">
      <label for="id_projet" class="form-label">Projet</label>
      <select class="form-select" id="id_projet" name="id_projet" required>
        <?php foreach ($projets as $p): ?>
          <option value="<?= $p->getId() ?>"><?= htmlspecialchars($p->getLabel()) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Afficher les examinateurs</button>
  </form>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
