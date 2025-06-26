<?php
require_once 'Model.php';

class ModelCreneau {

  private $id, $projet, $examinateur, $creneau;

  public function __construct($id = null, $projet = null, $examinateur = null, $creneau = null) {
    if (!is_null($id)) {
      $this->id = $id;
      $this->projet = $projet;
      $this->examinateur = $examinateur;
      $this->creneau = $creneau;
    }
  }

  // === Getters ===
  public function getId()            { return $this->id; }
  public function getProjet()        { return $this->projet; }
  public function getExaminateur()   { return $this->examinateur; }
  public function getCreneau()       { return $this->creneau; }

  // === 1. Tous les créneaux d’un examinateur
  public static function getByExaminateur($examinateur_id) {
    try {
      $db = Model::getInstance();
      $sql = "
        SELECT c.id, c.creneau, p.label AS projet
        FROM creneau c
        JOIN projet p ON c.projet = p.id
        WHERE c.examinateur = :eid
        ORDER BY c.creneau";
      $stmt = $db->prepare($sql);
      $stmt->execute(['eid' => $examinateur_id]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      $_SESSION['flash'] .= " Erreur DB : " . $e->getMessage();
      return [];
    }
  }

  // === 2. Créneaux par examinateur et projet
  public static function getByExaminateurAndProjet($examinateur_id, $projet_id) {
    try {
      $db = Model::getInstance();
      $sql = "
        SELECT c.id, c.creneau
        FROM creneau c
        WHERE c.examinateur = :eid AND c.projet = :pid
        ORDER BY c.creneau";
      $stmt = $db->prepare($sql);
      $stmt->execute([
        'eid' => $examinateur_id,
        'pid' => $projet_id
      ]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      $_SESSION['flash'] .= " Erreur DB : " . $e->getMessage();
      return [];
    }
  }

  // === 3. Insertion d’un créneau unique (validation + ID auto)
  public static function insert($projet_id, $examinateur_id, $datetime) {
    try {
      $db = Model::getInstance();

      // ✅ Vérification du format attendu : 'Y-m-d H:i:s'
      $dt = DateTime::createFromFormat('Y-m-d H:i:s', $datetime);
      if (!$dt) {
        $_SESSION['flash'] .= " Format datetime invalide : '$datetime'";
        return -1;
      }

      // 🔢 Récupération du prochain ID manuellement
      $stmt = $db->query("SELECT MAX(id) FROM creneau");
      $maxId = $stmt->fetchColumn();
      $nextId = is_null($maxId) ? 1 : $maxId + 1;

      // ✅ Insertion
      $sql = "INSERT INTO creneau (id, projet, examinateur, creneau)
              VALUES (:id, :pid, :eid, :dt)";
      $stmt = $db->prepare($sql);
      $stmt->execute([
        'id' => $nextId,
        'pid' => $projet_id,
        'eid' => $examinateur_id,
        'dt' => $datetime
      ]);

      return $nextId;
    } catch (PDOException $e) {
      $_SESSION['flash'] .= " Échec insertion '$datetime' : " . $e->getMessage();
      return -1;
    }
  }
}
