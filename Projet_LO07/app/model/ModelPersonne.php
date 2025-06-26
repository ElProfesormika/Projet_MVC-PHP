<!-- ===== début ModelPersonne.php -->
<?php
require_once 'Model.php';

class ModelPersonne {

  private $id, $nom, $prenom, $role_responsable, $role_examinateur, $role_etudiant, $login, $password;

  public function __construct($id = null, $nom = null, $prenom = null, $resp = null, $exam = null, $etud = null, $login = null, $password = null) {
    if (!is_null($id)) {
      $this->id = $id;
      $this->nom = $nom;
      $this->prenom = $prenom;
      $this->role_responsable = $resp;
      $this->role_examinateur = $exam;
      $this->role_etudiant = $etud;
      $this->login = $login;
      $this->password = $password;
    }
  }

  // ===================== GETTERS =====================
  public function getId() { return $this->id; }
  public function getNom() { return $this->nom; }
  public function getPrenom() { return $this->prenom; }
  public function getLogin() { return $this->login; }
  public function getPassword() { return $this->password; }
  public function isResponsable() { return $this->role_responsable; }
  public function isExaminateur() { return $this->role_examinateur; }
  public function isEtudiant() { return $this->role_etudiant; }

  // ===================== MÉTHODES STATIQUES =====================

  // Authentification (login + mot de passe)
  public static function checkLogin($login, $password) {
    try {
      $db = Model::getInstance();
      $sql = "SELECT * FROM personne WHERE login = :login AND password = :password";
      $stmt = $db->prepare($sql);
      $stmt->execute([
        'login' => $login,
        'password' => $password
      ]);
      $stmt->setFetchMode(PDO::FETCH_CLASS, 'ModelPersonne');
      return $stmt->fetch();
    } catch (PDOException $e) {
      printf("Erreur checkLogin : %s\n", $e->getMessage());
      return null;
    }
  }

  // Récupérer une personne par son ID
  public static function getById($id) {
    try {
      $db = Model::getInstance();
      $stmt = $db->prepare("SELECT * FROM personne WHERE id = :id");
      $stmt->execute(['id' => $id]);
      $stmt->setFetchMode(PDO::FETCH_CLASS, 'ModelPersonne');
      return $stmt->fetch();
    } catch (PDOException $e) {
      printf("Erreur getById : %s\n", $e->getMessage());
      return null;
    }
  }

  // Tous les utilisateurs (admin/dev uniquement)
  public static function getAll() {
    try {
      $db = Model::getInstance();
      $stmt = $db->query("SELECT * FROM personne ORDER BY nom, prenom");
      return $stmt->fetchAll(PDO::FETCH_CLASS, 'ModelPersonne');
    } catch (PDOException $e) {
      printf("Erreur getAll : %s\n", $e->getMessage());
      return [];
    }
  }

  // Liste des IDs
  public static function getAllId() {
    try {
      $db = Model::getInstance();
      $stmt = $db->query("SELECT id FROM personne");
      return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    } catch (PDOException $e) {
      printf("Erreur getAllId : %s\n", $e->getMessage());
      return [];
    }
  }

  // Insertion manuelle (utile en dev uniquement)
  public static function insert($nom, $prenom, $login, $password, $roles) {
  try {
    $db = Model::getInstance();
    $stmt = $db->query("SELECT MAX(id) FROM personne");
    $id = $stmt->fetchColumn() + 1;

    $sql = "INSERT INTO personne (id, nom, prenom, login, password, role_responsable, role_examinateur, role_etudiant)
            VALUES (:id, :nom, :prenom, :login, :password, :resp, :exam, :etud)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
      'id' => $id,
      'nom' => $nom,
      'prenom' => $prenom,
      'login' => $login,
      'password' => $password,
      'resp' => $roles['responsable'] ?? 0,
      'exam' => $roles['examinateur'] ?? 0,
      'etud' => $roles['etudiant'] ?? 0,
    ]);
    return $id;
  } catch (PDOException $e) {
    return -1;
  }
}
public static function getExaminateurs() {
  try {
    $db = Model::getInstance();
    $sql = "SELECT * FROM personne WHERE role_examinateur = 1 ORDER BY nom, prenom";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_CLASS, 'ModelPersonne');
  } catch (PDOException $e) {
    return [];
  }
}
public static function getExaminateursByProjet($id_projet) {
  try {
    $db = Model::getInstance();
    $sql = "SELECT DISTINCT p.*
            FROM personne p
            JOIN creneau c ON c.examinateur = p.id
            WHERE c.projet = :id_projet";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id_projet' => $id_projet]);
    return $stmt->fetchAll(PDO::FETCH_CLASS, 'ModelPersonne');
  } catch (PDOException $e) {
    return [];
  }
}

}
?>
<!-- ===== fin ModelPersonne.php -->
