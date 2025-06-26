<?php
require_once '../model/ModelPersonne.php';

class ControllerPersonne {

  // Affiche le formulaire de login
  public static function personneLogin($args = []) {
    include 'config.php';
    $vue = $root . '/app/view/personne/viewLogin.php';
    require($vue);
  }

  // Vérifie l'identifiant et initialise $_SESSION['user']
  public static function personneCheckLogin($args = []) {
    $login = htmlspecialchars($_GET['login'] ?? '');
    $password = htmlspecialchars($_GET['password'] ?? '');

    $user = ModelPersonne::checkLogin($login, $password);

    if ($user) {
      $_SESSION['user'] = [
        'id' => $user->getId(),
        'nom' => $user->getNom(),
        'prenom' => $user->getPrenom(),
        'login' => $user->getLogin(),
        'role_responsable' => $user->isResponsable(),
        'role_examinateur' => $user->isExaminateur(),
        'role_etudiant' => $user->isEtudiant()
      ];
      $_SESSION['flash'] = "Connexion réussie, bienvenue " . ucfirst($user->getPrenom()) . " !";
      header("Location: router1.php?action=accueil");
      exit();
    } else {
      $_SESSION['flash'] = "Identifiants incorrects.";
      header("Location: router1.php?action=personneLogin");
      exit();
    }
  }

  // Déconnexion (destruction de session)
  public static function personneLogout($args = []) {
    session_destroy();
    session_start();
    $_SESSION['flash'] = "Vous êtes déconnecté.";
    header("Location: router1.php?action=personneLogin");
    exit();
  }

  // Page d'accueil post-connexion
  public static function accueil($args = []) {
    include 'config.php';
    $vue = $root . '/app/view/personne/viewAccueil.php';
    require($vue);
  }
  // Affiche le formulaire d'inscription
public static function create($args = []) {
  include 'config.php';
  $vue = $root . '/app/view/personne/viewCreate.php';
  require($vue);
}

// Enregistre un nouvel utilisateur dans la base
public static function personneRegister($args = []) {
  $nom = htmlspecialchars($_POST['nom'] ?? '');
  $prenom = htmlspecialchars($_POST['prenom'] ?? '');
  $login = htmlspecialchars($_POST['login'] ?? '');
  $password = htmlspecialchars($_POST['password'] ?? '');
  $roles = $_POST['roles'] ?? [];

  if (empty($nom) || empty($prenom) || empty($login) || empty($password)) {
    $_SESSION['flash'] = "❗Tous les champs sont obligatoires.";
    header("Location: router1.php?action=create");
    exit();
  }

  $id = ModelPersonne::insert($nom, $prenom, $login, $password, $roles);

  if ($id > 0) {
    $_SESSION['flash'] = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
    header("Location: router1.php?action=personneLogin");
    exit();
  } else {
    $_SESSION['flash'] = "Échec de la création du compte (login déjà utilisé ?)";
    header("Location: router1.php?action=create");
    exit();
  }
}

}
