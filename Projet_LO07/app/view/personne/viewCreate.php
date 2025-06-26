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

  <h2 class="mb-4"> Inscription</h2>

  <form method="post" action="router1.php?action=personneRegister" class="w-50">

    <div class="mb-3">
      <label for="nom" class="form-label">Nom</label>
      <input type="text" class="form-control" id="nom" name="nom" required>
    </div>

    <div class="mb-3">
      <label for="prenom" class="form-label">Prénom</label>
      <input type="text" class="form-control" id="prenom" name="prenom" required>
    </div>

    <div class="mb-3">
      <label for="login" class="form-label">Login</label>
      <input type="text" class="form-control" id="login" name="login" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Mot de passe</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <label class="form-label">Rôles :</label><br>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" name="roles[responsable]" value="1">
      <label class="form-check-label">Responsable</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" name="roles[examinateur]" value="1">
      <label class="form-check-label">Examinateur</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" name="roles[etudiant]" value="1">
      <label class="form-check-label">Étudiant</label>
    </div>

    <br><br>
    <button type="submit" class="btn btn-primary">Créer un compte</button>
  </form>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
