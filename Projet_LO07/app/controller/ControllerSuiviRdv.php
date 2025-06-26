<?php
require_once '../model/ModelRdv.php';
require_once '../lib/auth.php';

class ControllerSuiviRdv {

  // === Responsable : voir les RDV de ses projets
  public static function rdvResponsable($args) {
    requireRole('responsable');
    $responsable_id = $_SESSION['user']['id'];
    $results = ModelRDV::getAllForResponsable($responsable_id);

    include 'config.php';
    $vue = $root . '/app/view/rdv/viewRdvProjet.php';
    require($vue);
  }

  // === Examinateur : voir les étudiants dans ses créneaux
  public static function rdvExaminateur($args) {
    requireRole('examinateur');
    $examinateur_id = $_SESSION['user']['id'];
    $results = ModelRDV::getAllForExaminateur($examinateur_id);

    include 'config.php';
    $vue = $root . '/app/view/rdv/viewRdvExaminateur.php';
    require($vue);
  }
}
