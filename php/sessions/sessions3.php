<?php
session_start();

// Réinitialisation complète des données de la partie
session_unset();

// Destruction de la session actuelle
session_destroy();

// Retour à la page d'accueil
header('Location: /TP1/index.php');
exit();
?>
