<?php
require_once 'Model.php';

class ModelRdv {
  private $id, $creneau, $etudiant;

  public function __construct($id = null, $creneau = null, $etudiant = null) {
    if (!is_null($id)) {
      $this->id = $id;
      $this->creneau = $creneau;
      $this->etudiant = $etudiant;
    }
  }

  // === Getters ===
  public function getId()        { return $this->id; }
  public function getCreneau()   { return $this->creneau; }
  public function getEtudiant()  { return $this->etudiant; }

  // === 1. Insertion d’un RDV (si creneau libre et étudiant dispo) ===
  public static function insert($creneau_id, $etudiant_id) {
    try {
      $db = Model::getInstance();

      // Créneau déjà pris ?
      $stmt = $db->prepare("SELECT COUNT(*) FROM rdv WHERE creneau = :c");
      $stmt->execute(['c' => $creneau_id]);
      if ($stmt->fetchColumn() > 0) return false;

      // Étudiant a-t-il déjà un RDV sur ce projet ?
      $stmt = $db->prepare("
        SELECT COUNT(*) 
        FROM rdv r
        JOIN creneau c ON r.creneau = c.id
        WHERE r.etudiant = :e AND c.projet IN (
          SELECT projet FROM creneau WHERE id = :c
        )
      ");
      $stmt->execute(['e' => $etudiant_id, 'c' => $creneau_id]);
      if ($stmt->fetchColumn() > 0) return false;

      // Insertion
      $stmt = $db->query("SELECT MAX(id) FROM rdv");
      $id = $stmt->fetchColumn() + 1;

      $stmt = $db->prepare("INSERT INTO rdv (id, creneau, etudiant) VALUES (:id, :c, :e)");
      $stmt->execute(['id' => $id, 'c' => $creneau_id, 'e' => $etudiant_id]);

      return true;
    } catch (PDOException $e) {
      printf("Erreur insert RDV : %s\n", $e->getMessage());
      return false;
    }
  }

  // === 2. Liste complète des RDV d’un étudiant ===
  public static function getAllByEtudiant($etudiant_id) {
    try {
      $db = Model::getInstance();
      $sql = "
        SELECT r.id, c.creneau, p.label AS projet,
               ex.nom AS exam_nom, ex.prenom AS exam_prenom
        FROM rdv r
        JOIN creneau c ON r.creneau = c.id
        JOIN projet p ON c.projet = p.id
        JOIN personne ex ON c.examinateur = ex.id
        WHERE r.etudiant = :eid
        ORDER BY c.creneau";
      $stmt = $db->prepare($sql);
      $stmt->execute(['eid' => $etudiant_id]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return [];
    }
  }

  // === 3. Supprime tous les RDV d’un étudiant (ou à adapter par ID) ===
  public static function deleteByEtudiant($etudiant_id) {
    try {
      $db = Model::getInstance();
      $stmt = $db->prepare("DELETE FROM rdv WHERE etudiant = :id");
      $stmt->execute(['id' => $etudiant_id]);
      return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
      printf("Erreur deleteByEtudiant : %s\n", $e->getMessage());
      return false;
    }
  }
  // === 4.Annuler un seul RDV par ID (et par sécurité, vérifier que c’est bien l’étudiant concerné)
public static function deleteById($rdv_id, $etudiant_id) {
  try {
    $db = Model::getInstance();
    $stmt = $db->prepare("
      DELETE FROM rdv
      WHERE id = :id AND etudiant = :eid
    ");
    $stmt->execute([
      'id' => $rdv_id,
      'eid' => $etudiant_id
    ]);
    return $stmt->rowCount() > 0;
  } catch (PDOException $e) {
    return false;
  }
}


  // === 5. Liste des créneaux disponibles ===
  public static function getAvailable() {
    try {
      $db = Model::getInstance();
      $sql = "
        SELECT c.id, p.label AS projet, c.creneau
        FROM creneau c
        JOIN projet p ON c.projet = p.id
        WHERE c.id NOT IN (SELECT creneau FROM rdv)
        ORDER BY c.creneau ASC";
      return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return [];
    }
  }

  // === 6. RDV par responsable (tous ses projets) ===
  public static function getAllForResponsable($responsable_id) {
    try {
      $db = Model::getInstance();
      $query = "
        SELECT r.id, p.label AS projet, c.creneau, e.nom, e.prenom
        FROM rdv r
        JOIN creneau c ON r.creneau = c.id
        JOIN projet p ON c.projet = p.id
        JOIN personne e ON r.etudiant = e.id
        WHERE p.responsable = :rid
        ORDER BY c.creneau";
      $stmt = $db->prepare($query);
      $stmt->execute(['rid' => $responsable_id]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return [];
    }
  }

  // === 7. RDV par examinateur ===
  public static function getAllForExaminateur($examinateur_id) {
    try {
      $db = Model::getInstance();
      $query = "
        SELECT r.id, c.creneau, p.label AS projet, e.nom, e.prenom
        FROM rdv r
        JOIN creneau c ON r.creneau = c.id
        JOIN projet p ON c.projet = p.id
        JOIN personne e ON r.etudiant = e.id
        WHERE c.examinateur = :eid
        ORDER BY c.creneau";
      $stmt = $db->prepare($query);
      $stmt->execute(['eid' => $examinateur_id]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return [];
    }
  }

  // === 8. Planning d’un projet complet (responsable) ===
  public static function getPlanningByProjet($id_projet) {
    try {
      $db = Model::getInstance();
      $sql = "
        SELECT r.id AS rdv_id, c.creneau AS date_heure,
               e.nom AS etu_nom, e.prenom AS etu_prenom,
               ex.nom AS exam_nom, ex.prenom AS exam_prenom
        FROM rdv r
        JOIN creneau c ON r.creneau = c.id
        JOIN personne e ON r.etudiant = e.id
        JOIN personne ex ON c.examinateur = ex.id
        WHERE c.projet = :id
        ORDER BY c.creneau";
      $stmt = $db->prepare($sql);
      $stmt->execute(['id' => $id_projet]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return [];
    }
  }

  // === 9. Tous les RDV d’un projet (responsable) ===
  public static function getAllByProjet($projet_id) {
    try {
      $db = Model::getInstance();
      $query = "
        SELECT r.id, r.creneau, r.etudiant,
               p.nom AS etu_nom, p.prenom AS etu_prenom,
               c.creneau AS horaire
        FROM rdv r
        JOIN personne p ON r.etudiant = p.id
        JOIN creneau c ON r.creneau = c.id
        WHERE c.projet = :pid
        ORDER BY c.creneau";
      $stmt = $db->prepare($query);
      $stmt->execute(['pid' => $projet_id]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return [];
    }
  }
}