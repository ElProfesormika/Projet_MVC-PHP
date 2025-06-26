<?php
require_once '../model/ModelCreneau.php';
require_once '../model/ModelProjet.php';
require_once '../lib/auth.php';

class ControllerCreneau {

  // 1. Liste des projets liés à un examinateur
  public static function projetsAvecCreneaux($args = []) {
    requireRole('examinateur');
    $examinateur_id = $_SESSION['user']['id'];
    $projets = ModelProjet::getByExaminateur($examinateur_id);

    include 'config.php';
    $vue = $root . '/app/view/creneau/viewMesProjetsExaminateur.php';
    require($vue);
  }

  // 2. Tous les créneaux de l’examinateur connecté
  public static function examinateurPlanning($args = []) {
    requireRole('examinateur');
    $examinateur_id = $_SESSION['user']['id'];
    $creneaux = ModelCreneau::getByExaminateur($examinateur_id);

    include 'config.php';
    $vue = $root . '/app/view/creneau/viewPlanning.php';
    require($vue);
  }

  // 3. Créneaux pour un projet sélectionné
  public static function examinateurCreneauxParProjet($args = []) {
    requireRole('examinateur');
    $examinateur_id = $_SESSION['user']['id'];

    if (!isset($_POST['id_projet'])) {
      $projets = ModelProjet::getByExaminateur($examinateur_id);
      include 'config.php';
      $vue = $root . '/app/view/creneau/viewSelectProjet.php';
      require($vue);
    } else {
      $id_projet = $_POST['id_projet'];
      $creneaux = ModelCreneau::getByExaminateurAndProjet($examinateur_id, $id_projet);
      include 'config.php';
      $vue = $root . '/app/view/creneau/viewCreneauxParProjet.php';
      require($vue);
    }
  }

  // 4. Formulaire pour ajouter un créneau unique
  public static function creneauCreate($args = []) {
    requireRole('examinateur');
    $projets = ModelProjet::getByExaminateur($_SESSION['user']['id']);
    include 'config.php';
    $vue = $root . '/app/view/creneau/viewCreateCreneau.php';
    require($vue);
  }

  // 4bis. Traitement d'ajout d'un seul créneau
  public static function creneauCreated($args = []) {
  requireRole('examinateur');

  $projet_id = htmlspecialchars($_POST['projet'] ?? '');
  $date = htmlspecialchars($_POST['date'] ?? '');
  $heure = htmlspecialchars($_POST['heure'] ?? '');
  $examinateur_id = $_SESSION['user']['id'];

  if (empty($projet_id) || empty($date) || $heure < 0 || $heure > 23) {
    $_SESSION['flash'] = "Données invalides.";
    header("Location: router1.php?action=creneauCreate");
    exit();
  }

  $datetime_str = $date . ' ' . str_pad($heure, 2, "0", STR_PAD_LEFT) . ':00:00';
  $dt = DateTime::createFromFormat('Y-m-d H:i:s', $datetime_str);

  if (!$dt) {
    $_SESSION['flash'] = "Format invalide pour la date/heure.";
    header("Location: router1.php?action=creneauCreate");
    exit();
  }

  $id = ModelCreneau::insert($projet_id, $examinateur_id, $dt->format('Y-m-d H:i:s'));
  $_SESSION['flash'] = $id > 0 ? " Créneau ajouté avec succès." : " Échec lors de l'ajout.";

  header("Location: router1.php?action=examinateurPlanning");
  exit();
}

  // 5. Formulaire pour ajouter une série de créneaux
  public static function creneauCreateSerie($args = []) {
    requireRole('examinateur');
    $projets = ModelProjet::getByExaminateur($_SESSION['user']['id']);
    include 'config.php';
    $vue = $root . '/app/view/creneau/viewCreateSerieCreneaux.php';
    require($vue);
  }

  // 5bis. Traitement de la série
  public static function creneauCreatedSerie($args = []) {
    requireRole('examinateur');
    
    $projet_id = htmlspecialchars($_POST['projet_id'] ?? '');
    $date = htmlspecialchars($_POST['date'] ?? '');
    $heure_debut = (int) ($_POST['heure'] ?? 8);
    $nb = (int) ($_POST['nb'] ?? 1);
    $examinateur_id = $_SESSION['user']['id'];

    if (empty($projet_id) || empty($date) || $nb < 1 || $nb > 10) {
      $_SESSION['flash'] = " Données invalides. Vérifiez le formulaire.";
      header("Location: router1.php?action=creneauCreateSerie");
      exit();
    }

    $inserted = 0;
    for ($i = 0; $i < $nb; $i++) {
      $hour = $heure_debut + $i;
      $datetime = DateTime::createFromFormat('Y-m-d H:i:s', "$date " . str_pad($hour, 2, "0", STR_PAD_LEFT) . ":00:00");

      if (!$datetime) {
        $_SESSION['flash'] .= " Heure invalide : $hour:00";
        continue;
      }

      $id = ModelCreneau::insert($projet_id, $examinateur_id, $datetime->format('Y-m-d H:i:s'));
      if ($id > 0) $inserted++;
    }

    $_SESSION['flash'] .= "$inserted créneaux ajoutés avec succès.";
    header("Location: router1.php?action=examinateurPlanning");
    exit();
  }
}
