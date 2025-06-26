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

  <h2> Proposition 1 : Exploitation intelligente des données</h2>

  <p>Nous proposons d'ajouter un tableau de bord d'analyse des données de soutenance :</p>
  <ul>
    <li> Nombre de rendez-vous planifiés</li>
    <li> Étudiants sans rendez-vous</li>
    <li> Examinateurs les plus sollicités</li>
    <li> Projets sans créneau</li>
  </ul>

  <div class="alert alert-info mt-4">
    Ces données peuvent être affichées avec des graphiques (ex. : Chart.js) ou des cartes Bootstrap
    <br>
    Objectif : aider les responsables à mieux organiser et répartir les soutenances.
  </div>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
