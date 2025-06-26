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

  <h2 class="mb-4"> Connexion</h2>

  <form method="get" action="router1.php" class="w-50">
    <input type="hidden" name="action" value="personneCheckLogin">

    <div class="mb-3">
      <label for="login" class="form-label">Identifiant (login)</label>
      <input type="text" class="form-control" id="login" name="login" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Mot de passe</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <button type="submit" class="btn btn-success">Se connecter</button>
  </form>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
