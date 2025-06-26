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

  <h2>🧱 Optimisation de la structure MVC</h2>

  <p>Nous proposons ici une amélioration de la structure MVC :</p>
  <ul>
    <li>️ Un moteur de rendu unique pour toutes les vues (`render()`)</li>
    <li>️ Suppression des répétitions dans chaque contrôleur</li>
    <li>️ Injection automatique des fragments (menu, flash, footer...)</li>
  </ul>

  <h4 class="text-success mt-4"> Exemple de code proposé :</h4>
  <pre class="bg-light p-3">
function render($vue, $data = []) {
  extract($data);
  require "$root/app/view/fragment/fragmentCaveHeader.html";
  require "$root/app/view/fragment/fragmentCaveMenu.html";
  require "$root/app/view/fragment/fragmentCaveFlash.html";
  require "$root/app/view/$vue";
  require "$root/app/view/fragment/fragmentCaveFooter.html";
}
  </pre>

  <p class="mt-3">️ À appeler dans le contrôleur avec : <code>render('xxx/viewXxx.php', $data);</code></p>
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
