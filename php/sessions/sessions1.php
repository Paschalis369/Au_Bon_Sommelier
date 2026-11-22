<?php
session_start();

$miseChoisie = $_POST["NosMises"] ?? null;
$nombreParie = $_POST["nombreParié"] ?? null;

// Vérification des données
if ($miseChoisie === null || $nombreParie === null || $nombreParie === "" || !is_numeric($nombreParie)) {
    exit("Erreur : mise ou nombre parié manquant.");
}

// Vérification de l'existence de la mise
if (!isset($_SESSION["valeurs_des_mises"][$miseChoisie]) || !isset($_SESSION["multiplicateurs"][$miseChoisie])) {
    exit("Erreur : mise inexistante.");
}

// Enregistrement des choix
$_SESSION["NosMises"] = $miseChoisie;
$_SESSION["nombreParié"] = (int)$nombreParie;

// Calcul du gain potentiel correspondant à la mise choisie
$valeurMise = $_SESSION["valeurs_des_mises"][$miseChoisie];
$multiplicateur = $_SESSION["multiplicateurs"][$miseChoisie];

$_SESSION["gain_potentiel"] =
    $valeurMise + (($valeurMise / 2) * $multiplicateur);

header('Location: /TP1/php/Au_Bon_Sommelier.php');
exit();
?>
