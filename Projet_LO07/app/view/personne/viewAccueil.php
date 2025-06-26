<?php
$root = dirname(__DIR__, 3);  
require($root . '/app/view/fragment/fragmentCaveHeader.html');
?>


<div class="container">
  <?php
    include $root . '/app/view/fragment/fragmentCaveMenu.html';
    include $root . '/app/view/fragment/fragmentCaveJumbotron.html';
    include $root . '/app/view/fragment/fragmentCaveFlash.html';
  ?>

  <?php if (!isset($_SESSION['user'])): ?>
    <div class="alert alert-warning">Vous n'êtes pas connecté.</div>
  <?php else: ?>
    <h2 class="text-success mb-4">
      Bienvenue, <?= htmlspecialchars($_SESSION['user']['prenom']) ?> 
    </h2>

    <p>Vous êtes connecté avec les rôles suivants :</p>
    <ul class="list-group w-50 mb-3">
      <?php if ($_SESSION['user']['role_etudiant']): ?>
        <li class="list-group-item"> Étudiant</li>
      <?php endif; ?>
      <?php if ($_SESSION['user']['role_responsable']): ?>
        <li class="list-group-item"> Responsable de projet</li>
      <?php endif; ?>
      <?php if ($_SESSION['user']['role_examinateur']): ?>
        <li class="list-group-item"> Examinateur</li>
      <?php endif; ?>
    </ul>

    <p>Utilisez le menu en haut pour accéder aux différentes fonctionnalités.</p>
  <?php endif; ?>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
