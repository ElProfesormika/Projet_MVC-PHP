<?php
// ----- début Router1 -----

// Inclusion des contrôleurs
require(__DIR__ . '/../controller/ControllerPersonne.php');
require(__DIR__ . '/../controller/ControllerProjet.php');
require(__DIR__ . '/../controller/ControllerCreneau.php');
require(__DIR__ . '/../controller/ControllerRdv.php');
require(__DIR__ . '/../controller/ControllerSuiviRdv.php');

// Configuration + session
include __DIR__ . '/../controller/config.php';
session_start();

// Récupération de l'action
$query_string = $_SERVER['QUERY_STRING'];
parse_str($query_string, $param);

$action = htmlspecialchars($param['action'] ?? 'personneLogin');
unset($param['action']);
$args = $param;

// Liste des actions possibles par contrôleur
$personneActions = [
  'personneLogin', 'personneCheckLogin', 'personneLogout',
  'accueil', 'create', 'personneRegister'
];

$projetActions = [
  'projetMesProjets', 'projetCreate', 'projetCreated',
  'examinateurList', 'examinateurAdd', 'examinateursParProjet', 'planningProjet'
];

$creneauActions = [
  'projetsAvecCreneaux', 'examinateurPlanning', 'examinateurCreneauxParProjet',
  'creneauCreate', 'creneauCreateSerie', 'creneauCreated', 'creneauCreatedSerie'
];

$rdvActions = [
  'etudiantVoirCreneaux', 'etudiantMesRdv', 'etudiantValiderRdv',
  'etudiantAnnulerRdv', 'etudiantAnnulerRdvById'
];

$suiviRdvActions = [
  'rdvResponsable', 'rdvExaminateur'
];

// Nouvelles vues pour les propositions d'innovation
$innovationViews = ['Proposition1', 'Proposition2'];

// Appel dynamique du bon contrôleur ou inclusion directe
if (in_array($action, $personneActions)) {
  ControllerPersonne::$action($args);
} elseif (in_array($action, $projetActions)) {
  ControllerProjet::$action($args);
} elseif (in_array($action, $creneauActions)) {
  ControllerCreneau::$action($args);
} elseif (in_array($action, $rdvActions)) {
  ControllerRdv::$action($args);
} elseif (in_array($action, $suiviRdvActions)) {
  ControllerSuiviRdv::$action($args);
} elseif (in_array($action, $innovationViews)) {
  // Chargement direct des vues statiques de proposition
  include __DIR__ . '/../controller/config.php';
  $vue = $root . "/app/view/innovation/view" . $action . ".php";
  require($vue);
} else {
  // Action inconnue → redirection vers login
  ControllerPersonne::personneLogin([]);
}

// ----- fin Router1 -----
