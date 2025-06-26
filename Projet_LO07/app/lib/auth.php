<?php

// Vérifie si un utilisateur est connecté
function isConnected() {
  return isset($_SESSION['user']);
}

// Vérifie si l'utilisateur a un rôle donné
function checkRole($role) {
  return isConnected() && !empty($_SESSION['user']['role_' . $role]);
}

// Redirige si l'utilisateur n'a pas le rôle attendu
function requireRole($role) {
  if (!checkRole($role)) {
    $_SESSION['flash'] = "Accès refusé (rôle requis : $role).";
    header("Location: router1.php?action=accueil");
    exit();
  }
}
