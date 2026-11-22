<?php
session_start();

if (!isset($_SESSION["gain_total_numerotes"])) {
    $_SESSION["gain_total_numerotes"] = [];
}

if (!isset($_SESSION["gain_total_devises"])) {
    $_SESSION["gain_total_devises"] = [];
}

if (!isset($_SESSION["gain_total_mises"])) {
    $_SESSION["gain_total_mises"] = [];
}

$name = $_SESSION["user_name"];
$choixDeDevise = $_SESSION["devise"];

$devises = $_SESSION["devises"];
$symboles_devises = $_SESSION["symboles_devises"];
$multiplicateurs_devises = $_SESSION["multiplicateurs_devises"];

$mises = $_SESSION["mises"];
$variables_de_mises = $_SESSION["variables_de_mises"];
$valeurs_standards_des_mises = $_SESSION["valeurs_standards_des_mises"];
$valeurs_des_mises = $_SESSION["valeurs_des_mises"];
$multiplicateurs = $_SESSION["multiplicateurs"];
$valeurs_des_intervalles = $_SESSION["valeurs_des_intervalles"];

$gain_potentiel = $_SESSION["gain_potentiel"];

$chiffre = $_SESSION['nombreParié'];
$choixDeMise = $_SESSION["NosMises"];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Au Bon Sommelier</title>

    <link rel="stylesheet" href="/TP1/css/Mises.css">
    <link rel="stylesheet" href="/TP1/css/sommelier.css">
</head>

<body>
    <div class="main">


        <div class="text">
            <h1>Résultats</h1>

            <?php
            $gain = 0;

            function chiffresTires(array $variables_de_mises)
            {
                echo ("<br>Les chiffres tirés sont : <br>");
                foreach ($variables_de_mises as $mise => $valeur) {
                    echo ("" . $mise . " : " . $valeur . "");
                    echo (" | ");
                }
                echo ("<br><br>");
            }

            function valeurs_de_mises(array $valStandard, string $choix, array $multDevises)
            {
                foreach ($valStandard as $mise => $valeur) {
                    $valeur *= $multDevises[$choix];
                    $valStandard[$mise] = $valeur;
                }

                return $valStandard;
            }



            function calculGains(array $multiplicateurs_devises, array $symb_dev, string $choixDeDevise): void
            {
                $devisesUtilisees = array_unique($_SESSION["gain_total_devises"]);

                $resultats = [];

                foreach ($devisesUtilisees as $deviseCible) {

                    $total = 0;

                    foreach ($_SESSION["gain_total_numerotes"] as $numero => $gainTour) {

                        $deviseSource = $_SESSION["gain_total_devises"][$numero];

                        $gainConverti =
                            ($gainTour / $multiplicateurs_devises[$deviseSource])
                            * $multiplicateurs_devises[$deviseCible];

                        $total += $gainConverti;
                    }

                    $resultats[] = number_format($total, 2, ',', ' ')
                        . " " . $symb_dev[$deviseCible];
                    // Récupération du gain dans la devise choisie
                    if ($deviseCible === $choixDeDevise) {
                        $gainFinal = $total;
                    }
                }

                $_SESSION["gain_final"] = $gainFinal;

                echo "<h3>Gain total : " . implode(" | ", $resultats) . "</h3>";
            }

            function remerciement(float $gain, array $symboles_devises, string $devise, string $choixDeMise, array $multiplicateurs_devises)
            {
                // 1. Enregistrement du nouveau tour
                $_SESSION["gain_total_numerotes"][] = $gain;
                $_SESSION["gain_total_devises"][] = $devise;
                $_SESSION["gain_total_mises"][] = $choixDeMise;

                echo "Vous repartez avec : "
                    . $gain . " " . $symboles_devises[$devise] . "!<br>";

                // 2. Historique : une ligne par tour
                echo "<h3>Historique de vos gains</h3>";

                foreach ($_SESSION["gain_total_numerotes"] as $numero => $gainTour) {

                    $deviseTour = $_SESSION["gain_total_devises"][$numero];
                    $miseTour = $_SESSION["gain_total_mises"][$numero];

                    echo "Tour " . ($numero + 1)
                        . " | Mise : " . htmlspecialchars($miseTour)
                        . " | Gain : "
                        . number_format($gainTour, 2, ',', ' ')
                        . " " . $symboles_devises[$deviseTour]
                        . "<br>";
                }

                // 3. Gain total : un seul affichage
                calculGains($multiplicateurs_devises, $symboles_devises, $devise);
            }


            function pariEnJeu($choixDeMise, array $valMise, string $mise, float $g_p, array $variables_de_mises, int $ch, array $nmbRandom, int $g, array $symb_dev, string $choixDeDevise, string $name, array $multiplicateurs_devises): void
            {
                echo ($name . ", vous avez choisi de miser sur : " . $choixDeMise . " (" . $symb_dev[$choixDeDevise] . ").<br>");
                echo ("<br>Vous avez misé " . $_SESSION['nombreParié'] . ".<br>Votre mise est de : " . $valMise[$mise] . " " . $symb_dev[$choixDeDevise] . ".<br>" . "Gain potentiel : " . $g_p . " " . $symb_dev[$choixDeDevise] . ".<br>");
                echo ("<br>");

                chiffresTires($variables_de_mises);

                echo ("<br>");
                if ($ch == $nmbRandom[$mise]) {
                    $g += $g_p;
                    echo ("Vous avez gagné " . $g . " " . $symb_dev[$choixDeDevise] . "!<br>Gain = " . $g . " " . $symb_dev[$choixDeDevise] . "<br>");
                    echo ("<br>");
                } else {
                    echo ("Vous avez perdu ! Gain = " . $g . " " . $symb_dev[$choixDeDevise] . "<br>");
                    echo ("<br>");
                }
                remerciement($g, $symb_dev, $choixDeDevise, $choixDeMise, $multiplicateurs_devises);
            }


            #contrôle de gain
            switch ($choixDeMise) {
                case $mises[0]: //piccolo
                    pariEnJeu($choixDeMise, $valeurs_des_mises, $mises[0], $gain_potentiel, $variables_de_mises, $chiffre, $variables_de_mises, $gain, $symboles_devises, $choixDeDevise, $name, $multiplicateurs_devises);
                    break;
                case $mises[1]: //chopine
                    pariEnJeu($choixDeMise, $valeurs_des_mises, $mises[1], $gain_potentiel, $variables_de_mises, $chiffre, $variables_de_mises, $gain, $symboles_devises, $choixDeDevise, $name, $multiplicateurs_devises);
                    break;
                case $mises[2]: //demi
                    pariEnJeu($choixDeMise, $valeurs_des_mises, $mises[2], $gain_potentiel, $variables_de_mises, $chiffre, $variables_de_mises, $gain, $symboles_devises, $choixDeDevise, $name, $multiplicateurs_devises);
                    break;
                case $mises[3]: //standard
                    pariEnJeu($choixDeMise, $valeurs_des_mises, $mises[3], $gain_potentiel, $variables_de_mises, $chiffre, $variables_de_mises, $gain, $symboles_devises, $choixDeDevise, $name, $multiplicateurs_devises);
                    break;
                case $mises[4]: //magnum
                    pariEnJeu($choixDeMise, $valeurs_des_mises, $mises[4], $gain_potentiel, $variables_de_mises, $chiffre, $variables_de_mises, $gain, $symboles_devises, $choixDeDevise, $name, $multiplicateurs_devises);
                    break;
                case $mises[5]: //jeroboam
                    pariEnJeu($choixDeMise, $valeurs_des_mises, $mises[5], $gain_potentiel, $variables_de_mises, $chiffre, $variables_de_mises, $gain, $symboles_devises, $choixDeDevise, $name, $multiplicateurs_devises);
                    break;
                case $mises[6]: //imperial
                    pariEnJeu($choixDeMise, $valeurs_des_mises, $mises[6], $gain_potentiel, $variables_de_mises, $chiffre, $variables_de_mises, $gain, $symboles_devises, $choixDeDevise, $name, $multiplicateurs_devises);
                    break;
                case $mises[7]: //salmanazar
                    pariEnJeu($choixDeMise, $valeurs_des_mises, $mises[7], $gain_potentiel, $variables_de_mises, $chiffre, $variables_de_mises, $gain, $symboles_devises, $choixDeDevise, $name, $multiplicateurs_devises);
                    break;
                case $mises[8]: //balthazar
                    pariEnJeu($choixDeMise, $valeurs_des_mises, $mises[8], $gain_potentiel, $variables_de_mises, $chiffre, $variables_de_mises, $gain, $symboles_devises, $choixDeDevise, $name, $multiplicateurs_devises);
                    break;
                case $mises[9]: //nabuchodonosor
                    pariEnJeu($choixDeMise, $valeurs_des_mises, $mises[9], $gain_potentiel, $variables_de_mises, $chiffre, $variables_de_mises, $gain, $symboles_devises, $choixDeDevise, $name, $multiplicateurs_devises);
                    break;
                default:
                    echo "Mise inexistante.<br>Les bonnes mises sont : " . implode(", ", $mises);
            }

            ?>

            <ul>
                <li>
                    <form action="/TP1/php/sessions/sessions3.php">
                        <button type="submit">
                            Recommencer
                        </button>
                    </form>
                </li>
                <li>
                    <form action="/TP1/php/sessions/sessions2.php">
                        <button type="submit">
                            Rejouer
                        </button>
                    </form>
                </li>
                <li>
                    <form action="/TP1/php/Au_revoir.php">
                        <button>
                            S'arrêter
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>

</body>

</html>