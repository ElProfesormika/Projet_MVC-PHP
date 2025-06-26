<?php

class ControllerCave {

  // === Page d'accueil du projet
  public static function accueil($args = []) {
    include 'config.php';
    $vue = $root . '/app/view/viewAccueil.php';
    require($vue);
  }

  // === Proposition d'amélioration 1
  public static function caveProposition1($args = []) {
    include 'config.php';
    $vue = $root . '/app/view/documentation/viewProposition1.php';
    require($vue);
  }

  // === Proposition d'amélioration 2
  public static function caveProposition2($args = []) {
    include 'config.php';
    $vue = $root . '/app/view/documentation/viewProposition2.php';
    require($vue);
  }
}
