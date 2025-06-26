<!-- ----- début Model.php -->
<?php

class Model extends PDO {

  private static $_instance;

  // Constructeur : protégé pour éviter une instanciation directe
  protected function __construct() {}

  // Singleton : crée une unique instance PDO
  public static function getInstance() {
    if (!isset(self::$_instance)) {
      // Chargement du fichier config
      $config_path = dirname(__DIR__) . '/controller/config.php';
      if (file_exists($config_path)) {
        include $config_path;
      } else {
        die("<strong style='color:red;'>Fichier config.php non trouvé à : $config_path</strong>");
      }

      // Vérifie si les variables sont bien définies
      if (!isset($dsn, $username, $password)) {
        die("<strong style='color:red;'>Erreur : variables de configuration BDD manquantes (dsn, username, password)</strong>");
      }

      if (defined('DEBUG') && DEBUG) {
        echo "<ul style='color:blue;'>";
        echo "<li><strong>DSN :</strong> $dsn</li>";
        echo "<li><strong>Username :</strong> $username</li>";
        echo "<li><strong>Password :</strong> ******</li>";
        echo "</ul>";
      }

      $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ];

      try {
        self::$_instance = new PDO($dsn, $username, $password, $options);
      } catch (PDOException $e) {
        echo "<div style='color:red;'><strong>Erreur PDO :</strong> " . $e->getMessage() . "</div>";
        die();
      }
    }

    return self::$_instance;
  }
}
?>
<!-- ----- fin Model.php -->
