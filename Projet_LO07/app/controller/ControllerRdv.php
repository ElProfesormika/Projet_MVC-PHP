<?php
require_once '../model/ModelRdv.php';
require_once '../model/ModelCreneau.php';
require_once '../lib/auth.php';

class ControllerRdv {

  // === 1. Affiche la liste complète des RDV de l'étudiant
  public static function etudiantMesRdv($args = []) {
    requireRole('etudiant');

    $etudiant_id = $_SESSION['user']['id'];
    $rdvs = ModelRdv::getAllByEtudiant($etudiant_id);

    include 'config.php';
    $vue = $root . '/app/view/rdv/viewMesRdv.php';
    require($vue);
  }

  // === 2. Affiche les créneaux disponibles pour prendre un nouveau RDV
  public static function etudiantVoirCreneaux($args = []) {
    requireRole('etudiant');

    $creneaux = ModelRdv::getAvailable();

    include 'config.php';
    $vue = $root . '/app/view/rdv/viewCreneauxDispo.php';
    require($vue);
  }

  // === 3. Valide la réservation d’un nouveau RDV
  public static function etudiantValiderRdv($args) {
    requireRole('etudiant');

    $etudiant_id = $_SESSION['user']['id'];
    $creneau_id = htmlspecialchars($args['id_creneau'] ?? '');

    if (empty($creneau_id)) {
      $_SESSION['flash'] = "Aucun créneau sélectionné.";
    } else {
      $ok = ModelRdv::insert($creneau_id, $etudiant_id);
      $_SESSION['flash'] = $ok
        ? "Rendez-vous réservé avec succès."
        : "Impossible de réserver ce créneau (déjà pris ou projet déjà sélectionné).";
    }

    header("Location: router1.php?action=etudiantMesRdv");
    exit();
  }

  // === 4. Annule tous les RDV de l’étudiant (à adapter si on veut un par ID)
  public static function etudiantAnnulerRdv($args = []) {
    requireRole('etudiant');

    $etudiant_id = $_SESSION['user']['id'];
    $ok = ModelRdv::deleteByEtudiant($etudiant_id);

    $_SESSION['flash'] = $ok
      ? "Tous vos RDV ont été annulés."
      : "Aucun RDV à annuler.";

    header("Location: router1.php?action=etudiantMesRdv");
    exit();
  }
  // === Annule un RDV spécifique (sécurisé pour l'étudiant connecté)
public static function etudiantAnnulerRdvById($args = []) {
  requireRole('etudiant');

  $etudiant_id = $_SESSION['user']['id'];
  $rdv_id = htmlspecialchars($args['id_rdv'] ?? null);

  if (!$rdv_id) {
    $_SESSION['flash'] = "Aucun identifiant de RDV fourni.";
  } else {
    $ok = ModelRdv::deleteById($rdv_id, $etudiant_id);
    $_SESSION['flash'] = $ok
      ? " Rendez-vous annulé."
      : "Impossible d’annuler ce rendez-vous.";
  }

  header("Location: router1.php?action=etudiantMesRdv");
  exit();
}
}
