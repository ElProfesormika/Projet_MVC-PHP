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

  <h2> Ajout d’un projet</h2>

  <form method="post" action="router1.php?action=projetCreated" class="w-50">
    <div class="mb-3">
      <label for="label" class="form-label">Label du projet</label>
      <input type="text" class="form-control" id="label" name="label" required>
    </div>

    <div class="mb-3">
      <label for="groupe" class="form-label">Nombre d'étudiants (1 à 5)</label>
      <input type="number" class="form-control" id="groupe" name="groupe" min="1" max="5" required>
    </div>

    <button type="submit" class="btn btn-primary">Créer le projet</button>
  </form>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
