<!-- ----- début config -->
<?php

// Activation du mode DEBUG si non défini
if (!defined('DEBUG')) {
  define('DEBUG', false);  // Met à true en dev local
}

// Indicateur de travail en local ou sur serveur DEV-ISI
if (!defined('LOCAL')) {
  define('LOCAL', false); // true = localhost | false = dev-isi
}

// === Configuration de la base de données ===
if (LOCAL) {
  $dsn = 'mysql:host=localhost;dbname=soutenances;charset=utf8';
  $username = 'root';
  $password = 'root';
} else {
  $dsn = 'mysql:host=localhost;dbname=yabrehou;charset=utf8';
  $username = 'yabrehou';
  $password = '61R28zKD';
}

// === Définition du root path (vers dossier du projet) ===
$root = dirname(dirname(__DIR__)) . '/';

// === Affichage debug ===
if (DEBUG) {
  echo "<ul style='font-size:small; color:gray'>";
  echo "<li><strong>DSN :</strong> $dsn</li>";
  echo "<li><strong>User :</strong> $username</li>";
  echo "<li><strong>Root :</strong> $root</li>";
  echo "</ul>";
}
?>
<!-- ----- fin config -->
