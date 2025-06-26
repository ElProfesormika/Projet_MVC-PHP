<?php
require_once '../model/ModelProjet.php';

class ControllerProjet {

  // Affiche les projets du responsable connecté
  public static function projetMesProjets($args = []) {
    include 'config.php';

    if (!isset($_SESSION['user']) || empty($_SESSION['user']['role_responsable'])) {
      $_SESSION['flash'] = "Accès refusé. Vous n'êtes pas responsable.";
      header("Location: router1.php?action=accueil");
      exit();
    }

    $id_responsable = $_SESSION['user']['id'];
    $projets = ModelProjet::getByResponsable($id_responsable);

    $vue = $root . '/app/view/projet/viewMesProjets.php';
    require($vue);
    
  }
  
  public static function projetCreate($args = []) {
  include 'config.php';

  if (!isset($_SESSION['user']) || empty($_SESSION['user']['role_responsable'])) {
    $_SESSION['flash'] = "Accès refusé. Vous n'êtes pas responsable.";
    header("Location: router1.php?action=accueil");
    exit();
  }

  $vue = $root . '/app/view/projet/viewCreateProjet.php';
  require($vue);
}

public static function projetCreated($args = []) {
  include 'config.php';

  if (!isset($_SESSION['user']) || empty($_SESSION['user']['role_responsable'])) {
    $_SESSION['flash'] = "Accès refusé.";
    header("Location: router1.php?action=accueil");
    exit();
  }

  $label = htmlspecialchars($_POST['label'] ?? '');
  $groupe = (int)($_POST['groupe'] ?? 0);
  $responsable = $_SESSION['user']['id'];

  if (empty($label) || $groupe < 1 || $groupe > 5) {
    $_SESSION['flash'] = "Erreur : tous les champs sont requis et le groupe doit être entre 1 et 5.";
    header("Location: router1.php?action=projetCreate");
    exit();
  }

  $id = ModelProjet::insert($label, $responsable, $groupe);

  if ($id > 0) {
    $_SESSION['flash'] = "Projet ajouté avec succès.";
    header("Location: router1.php?action=projetMesProjets");
    exit();
  } else {
    $_SESSION['flash'] = "Échec de l'ajout du projet.";
    header("Location: router1.php?action=projetCreate");
    exit();
  }
}
public static function examinateurList($args = []) {
  include 'config.php';

  if (!isset($_SESSION['user']) || empty($_SESSION['user']['role_responsable'])) {
    $_SESSION['flash'] = "Accès refusé.";
    header("Location: router1.php?action=accueil");
    exit();
  }

  $examinateurs = ModelPersonne::getExaminateurs();
  $vue = $root . '/app/view/projet/viewExaminateurList.php';
  require($vue);
}
public static function examinateurAdd($args = []) {
  include 'config.php';
  $vue = $root . '/app/view/projet/viewAddExaminateur.php';
  require($vue);
}

public static function examinateurAdded($args = []) {
  $nom = htmlspecialchars($_POST['nom'] ?? '');
  $prenom = htmlspecialchars($_POST['prenom'] ?? '');
  $login = strtolower($nom . '.' . $prenom);
  $password = "exam" . rand(100, 999); // mot de passe par défaut

  $roles = ['examinateur' => 1]; // uniquement examinateur

  $id = ModelPersonne::insert($nom, $prenom, $login, $password, $roles);

  if ($id > 0) {
    $_SESSION['flash'] = "Nouvel examinateur ajouté avec succès (login : $login, mdp : $password)";
  } else {
    $_SESSION['flash'] = "Échec lors de l'ajout.";
  }
  header("Location: router1.php?action=examinateurList");
  exit();
}
public static function examinateursParProjet($args = []) {
  include 'config.php';

  if (!isset($_SESSION['user']) || empty($_SESSION['user']['role_responsable'])) {
    $_SESSION['flash'] = "Accès refusé.";
    header("Location: router1.php?action=accueil");
    exit();
  }

  $id_responsable = $_SESSION['user']['id'];

  if (!isset($_POST['id_projet'])) {
    // Étape 1 : afficher les projets disponibles
    $projets = ModelProjet::getByResponsable($id_responsable);
    $vue = $root . '/app/view/projet/viewSelectProjetExaminateurs.php';
    require($vue);
  } else {
    // Étape 2 : afficher les examinateurs liés au projet
    $id_projet = $_POST['id_projet'];
    $examinateurs = ModelPersonne::getExaminateursByProjet($id_projet);
    $vue = $root . '/app/view/projet/viewExaminateursProjet.php';
    require($vue);
  }
}
public static function planningProjet($args = []) {
  include 'config.php';

  if (!isset($_SESSION['user']) || empty($_SESSION['user']['role_responsable'])) {
    $_SESSION['flash'] = "Accès refusé.";
    header("Location: router1.php?action=accueil");
    exit();
  }

  $id_responsable = $_SESSION['user']['id'];

  if (!isset($_POST['id_projet'])) {
    // Étape 1 : sélection du projet
    $projets = ModelProjet::getByResponsable($id_responsable);
    $vue = $root . '/app/view/projet/viewSelectProjetPlanning.php';
    require($vue);
  } else {
    $id_projet = $_POST['id_projet'];
    $rdvs = ModelRdv::getPlanningByProjet($id_projet);
    $vue = $root . '/app/view/projet/viewPlanningProjet.php';
    require($vue);
  }
}

}
