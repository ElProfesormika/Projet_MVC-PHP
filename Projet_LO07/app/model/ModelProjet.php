<?php
require_once 'Model.php';

class ModelProjet {

  private $id, $label, $responsable, $groupe;

  public function __construct($id = null, $label = null, $responsable = null, $groupe = null) {
    if (!is_null($id)) {
      $this->id = $id;
      $this->label = $label;
      $this->responsable = $responsable;
      $this->groupe = $groupe;
    }
  }

  public function getId() { return $this->id; }
  public function getLabel() { return $this->label; }
  public function getResponsable() { return $this->responsable; }
  public function getGroupe() { return $this->groupe; }

  // Liste des projets d'un responsable donné
  public static function getByResponsable($id_responsable) {
    try {
      $db = Model::getInstance();
      $sql = "SELECT * FROM projet WHERE responsable = :id ORDER BY label";
      $stmt = $db->prepare($sql);
      $stmt->execute(['id' => $id_responsable]);
      return $stmt->fetchAll(PDO::FETCH_CLASS, 'ModelProjet');
    } catch (PDOException $e) {
      printf("Erreur getByResponsable : %s\n", $e->getMessage());
      return [];
    }
  }
  public static function insert($label, $responsable, $groupe) {
  try {
    $db = Model::getInstance();
    $stmt = $db->query("SELECT MAX(id) FROM projet");
    $id = $stmt->fetchColumn() + 1;

    $sql = "INSERT INTO projet (id, label, responsable, groupe)
            VALUES (:id, :label, :responsable, :groupe)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
      'id' => $id,
      'label' => $label,
      'responsable' => $responsable,
      'groupe' => $groupe
    ]);
    return $id;
  } catch (PDOException $e) {
    return -1;
  }
}
public static function getByExaminateur($examinateur_id) {
  try {
    $db = Model::getInstance();
    $query = "
      SELECT DISTINCT p.*
      FROM projet p
      JOIN creneau c ON p.id = c.projet
      WHERE c.examinateur = :eid
      ORDER BY p.label";
    $stmt = $db->prepare($query);
    $stmt->execute(['eid' => $examinateur_id]);
    return $stmt->fetchAll(PDO::FETCH_CLASS, 'ModelProjet');
  } catch (PDOException $e) {
    return [];
  }
}

}
