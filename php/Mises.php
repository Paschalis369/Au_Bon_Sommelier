<?php
#données du parieur
session_start();

$name = $_SESSION['user_name'];
$choixDeDevise = $_SESSION['devise'];

#possibilités
$devises = ["euro", "dollar", "franc", "livre", "franc_suisse", "yen", "dollar_canadien", "yuan"];
$symboles_devises = [
    "euro" => "€",
    "dollar" => "$",
    "franc" => "FCFA",
    "livre" => "£",
    "franc_suisse" => "CHF",
    "yen" => "¥",
    "dollar_canadien" => "C$",
    "yuan" => "¥"
];
$multiplicateurs_devises = [
    "euro" => 1,
    "dollar" => 1.1057,
    "franc" => 655.957,
    "livre" => 0.8361,
    "franc_suisse" => 0.9240,
    "yen" => 176.868,
    "dollar_canadien" => 1.5770,
    "yuan" => 7.3754
];

$_SESSION["devises"] = $devises;
$_SESSION["symboles_devises"] = $symboles_devises;
$_SESSION["multiplicateurs_devises"] = $multiplicateurs_devises;

function valeurs_de_mises($valStandard, $choix, $multDevises)
{
    foreach ($valStandard as $mise => $valeur) {
        $valeur *= $multDevises[$choix];
        $valStandard[$mise] = $valeur;
    }

    return $valStandard;
}

$mises = [
    "Demi",
    "Standard",
    "Magnum",
    "Double Magnum",
    "Jeroboam",
    "Imperial",
    "Salmanazar",
    "Balthazar",
    "Nabuchodonosor",
    "Melchior"
];
$variables_de_mises = [];
$valeurs_standards_des_mises = [
    "Demi" => 7.5,
    "Standard" => 15,
    "Magnum" => 30,
    "Double Magnum" => 60,
    "Jeroboam" => 90,
    "Imperial" => 120,
    "Salmanazar" => 180,
    "Balthazar" => 240,
    "Nabuchodonosor" => 300,
    "Melchior" => 360
];
$valeurs_des_mises = valeurs_de_mises($valeurs_standards_des_mises, $choixDeDevise, $multiplicateurs_devises);
$multiplicateurs = [
    "Demi" => 0.5,
    "Standard" => 1,
    "Magnum" => 2,
    "Double Magnum" => 4,
    "Jeroboam" => 6,
    "Imperial" => 8,
    "Salmanazar" => 12,
    "Balthazar" => 16,
    "Nabuchodonosor" => 20,
    "Melchior" => 24
];
$valeurs_des_intervalles = [];

foreach ($multiplicateurs as $mise => $multiplicateur) {
    $valeurs_des_intervalles[$mise] = 800 / $multiplicateur;
}

foreach ($valeurs_des_intervalles as $mise => $valeur) {
    $variables_de_mises[$mise] = rand(0, $valeur);
}

$_SESSION["mises"] = $mises;
$_SESSION["variables_de_mises"] = $variables_de_mises;
$_SESSION["valeurs_standards_des_mises"] = $valeurs_standards_des_mises;
$_SESSION["valeurs_des_mises"] = $valeurs_des_mises;
$_SESSION["multiplicateurs"] = $multiplicateurs;
$_SESSION["valeurs_des_intervalles"] = $valeurs_des_intervalles;

function gain_potentiel($valeurMise, string $mise, $mult)
{
    $g_p = $valeurMise[$mise] + (($valeurMise[$mise] / 2) * $mult[$mise]);
    $_SESSION["gain_potentiel"] = $g_p;
    return $g_p;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Mises</title>

    <link rel="stylesheet" href="/TP1/css/mises.css">
</head>

<body>
    <div class="main">
        <h1 class="text">Nos Mises</h1>
        <form id="form" action="/TP1/php/sessions/sessions1.php" method="post">
            <div class="text">
                <h2>
                    <?= htmlspecialchars($name); ?>, vous souhaitez jouer avec
                    <?= htmlspecialchars($choixDeDevise) . " (" . $symboles_devises[$choixDeDevise] . ")"; ?>
                    comme
                    devise.<br>
                </h2>
                <br>
                <h2>Appréciez Nos Options de Mises, et choisissez-en une :</h2>
            </div>
            <div class="mises">
                <?php foreach ($mises as $mise): ?>
                    <div class="UneMise">
                        <input type="radio" name="NosMises" id="<?= $mise; ?>" value="<?= $mise; ?>" required />
                        <label for="<?= $mise; ?>">
                            <h3>
                                <?= $mise; ?>
                            </h3>
                            <p>
                                Mise :
                                <?=
                                    $valeurs_des_mises[$mise] . " " . $symboles_devises[$choixDeDevise];
                                ?>
                            </p>
                            <p>
                                Intervalle : [0,
                                <?= 
                                round($valeurs_des_intervalles[$mise]); 
                                ?>]
                            </p>
                            <p>
                                Gain potentiel :
                                <?=
                                    number_format(gain_potentiel($valeurs_des_mises, $mise, $multiplicateurs), 0, ',', ' ') . " " . $symboles_devises[$choixDeDevise];
                                ?>
                            </p>
                        </label>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="pari">
                <input type="number" id="nombreParié" name="nombreParié" size="30" min="0"
                    placeholder="Que pariez-vous comme résultat ?" required />

                <br />

                <input type="submit" value="Pariez !" />
            </div>
        </form>
    </div>

    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous">
        </script>

</body>

</html>