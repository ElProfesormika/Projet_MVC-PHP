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

  <h2> Mes projets examinés</h2>

  <?php if (empty($projets)): ?>
    <p>Aucun projet affecté à vos créneaux.</p>
  
  <?php else: ?>
    <table class="table table-bordered">
      <thead class="table-success">
        <tr>
          <th>Nom du Projet</th>
          <th>Nombre d'étudiants</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($projets as $p): ?>
          <tr>
            <td><?= htmlspecialchars($p->getLabel()) ?></td>
            <td><?= htmlspecialchars($p->getGroupe()) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>   
</div>

<?php require($root . '/app/view/fragment/fragmentCaveFooter.html'); ?>
