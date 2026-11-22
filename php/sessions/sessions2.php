<?php
session_start();

// On efface uniquement les données du tour précédent
unset($_SESSION["NosMises"]);
unset($_SESSION["nombreParié"]);
unset($_SESSION["gain_potentiel"]);

// On conserve l'identité, la devise et l'historique
header('Location: /TP1/php/Mises.php');
exit();
?>
