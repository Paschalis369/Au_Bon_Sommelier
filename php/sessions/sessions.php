<?php
session_start();

$_SESSION["user_name"] = $_POST["user_name"] ?? null;
$_SESSION["devise"] = $_POST["devise"] ?? null;

if (empty($_SESSION["user_name"]) || empty($_SESSION["devise"])) {
    exit("Erreur : nom ou devise manquant.");
}

header('Location: /TP1/php/Mises.php');
exit();
?>