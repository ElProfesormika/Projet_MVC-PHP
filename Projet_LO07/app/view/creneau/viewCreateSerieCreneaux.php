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

  <h2>Ajouter une série de créneaux</h2>

  <form method="post" action="router1.php?action=creneauCreatedSerie" class="w-50">

    <!-- Projet -->
    <div class="mb-3">
      <label for="projet" class="form-label">Sélectionnez un projet</label>
      <select class="form-select" name="projet_id" id="projet" required>
        <?php foreach ($projets as $p): ?>
          <option value="<?= $p->getId() ?>"><?= htmlspecialchars($p->getLabel()) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Date -->
    <div class="mb-3">
      <label for="date" class="form-label">Date</label>
      <input type="date" class="form-control" name="date" id="date" required>
    </div>

    <!-- Heure de début -->
    <div class="mb-3">
      <label for="heure" class="form-label">Heure de début</label>
      <select class="form-select" name="heure" id="heure" required>
        <?php for ($h = 8; $h <= 18; $h++): ?>
          <option value="<?= $h ?>"><?= str_pad($h, 2, "0", STR_PAD_LEFT) ?>:00</option>
        <?php endfor; ?>
      </select>
    </div>

    <!-- Nombre de créneaux -->
    <div class="mb-3">
      <label for="nb" class="form-label">Nombre de créneaux (1 à 10)</label>
      <select class="form-select" name="nb" id="nb" required>
        <?php for ($i = 1; $i <= 10; $i++): ?>
          <option value="<?= $i ?>"><?= $i ?></option>
        <?php endfor; ?>
      </select>
    </div>

    <button type="submit" class="btn btn-success">Créer la série</button>
  </form>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
