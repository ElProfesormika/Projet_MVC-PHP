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

  <h2>Confirmation</h2>
  <p>Vous pouvez vérifier votre rendez-vous dans la section <a href="router1.php?action=etudiantMesRdv">"Mes RDV"</a>.</p>

</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
