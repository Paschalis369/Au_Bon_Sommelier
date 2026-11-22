<?php
session_start();

$choixDeDevise = $_SESSION["devise"];
$symboles_devises = $_SESSION["symboles_devises"];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Au revoir</title>

    <link rel="stylesheet" href="/TP1/css/style.css">
    <link rel="stylesheet" href="/TP1/css/end.css">
</head>

<body>
    <div class="main">
        <div class="banner">
            <img class="contenu" src="/TP1/img/Bordeaux_Brown_and_Beige_Photographic_Modern_Wine_Presentation.png"
                alt="Au_Bon_Sommelier" />

            <div class="text">
                <h1>
                    Au revoir <?= $_SESSION["user_name"]; ?> !
                </h1>
                <br>
                <h2>Votre gain final aura été de
                    <?= number_format($_SESSION["gain_final"] ?? 0, 2, ',', ' ')
                        . " "
                        . $_SESSION["symboles_devises"][$_SESSION["devise"]]; ?>.
                </h2>
            </div>
        </div>

        <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL"
            crossorigin="anonymous"></script>
</body>

</html>


<?php
// Réinitialisation complète des données de la partie
session_unset();

// Destruction de la session actuelle
session_destroy();
exit();
?>
