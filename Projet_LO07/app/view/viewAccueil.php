<!-- ----- début viewAccueil.php -->
<?php require($root . '/app/view/fragment/fragmentCaveHeader.html'); ?>

<div class="container">
  <?php
    include $root . '/app/view/fragment/fragmentCaveMenu.html';
    include $root . '/app/view/fragment/fragmentCaveJumbotron.html';
    include $root . '/app/view/fragment/fragmentCaveFlash.html';
  ?>

  <div class="p-4 bg-light rounded shadow-sm mt-3">
    <h2>Bienvenue sur l'application de gestion des soutenances</h2>
    <p class="lead">Ce portail vous permet d'organiser les projets, planifier les créneaux de soutenance et gérer les rendez-vous des étudiants.</p>
    
    <ul>
      <li><strong>Étudiants :</strong> prenez rendez-vous en choisissant un créneau libre.</li>
      <li><strong>Examinateurs :</strong> ajoutez et visualisez vos créneaux.</li>
      <li><strong>Responsables :</strong> gérez vos projets et suivez les rendez-vous.</li>
    </ul>

    <p class="mt-3 text-muted">Développé par <strong>YABRE Housséni - FOTIO NGNINLAJUNG Francky Steve </strong> – UTT 2025</p>
  </div>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
<!-- ----- fin viewAccueil.php -->
