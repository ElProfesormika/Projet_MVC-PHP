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

  <h2>Ajouter un créneau</h2>

  <form method="post" action="router1.php?action=creneauCreated" class="w-50">

    <!-- Projet -->
    <div class="mb-3">
      <label for="projet" class="form-label">Projet</label>
      <select class="form-select" name="projet" id="projet" required>
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

    <!-- Heure -->
    <div class="mb-3">
      <label for="heure" class="form-label">Heure</label>
      <select class="form-select" name="heure" id="heure" required>
        <?php for ($h = 8; $h <= 18; $h++): ?>
          <option value="<?= $h ?>"><?= str_pad($h, 2, '0', STR_PAD_LEFT) ?>:00</option>
        <?php endfor; ?>
      </select>
    </div>

    <button type="submit" class="btn btn-success">Ajouter le créneau</button>
  </form>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
