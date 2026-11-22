<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $_SESSION = [];
    session_regenerate_id(true);
}

$name = $_SESSION["user_name"] ?? '';
$choixDeDevise = $_SESSION["devise"] ?? '';
?>

<!doctype html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Au Bon Sommelier</title>

  <link rel="stylesheet" href="/TP1/css/style.css" />
</head>

<body>
  <div class="main">
    <div class="banner">
      <img class="contenu" src="img/Bordeaux_Brown_and_Beige_Photographic_Modern_Wine_Presentation.png"
        alt="Au_Bon_Sommelier" />
      <form id="form" action="/TP1/php/sessions/sessions.php" method="post">
        <input type="text" id="name" name="user_name" size="30" placeholder="Comment nous nommerons-nous ?"
          value="<?= htmlspecialchars($name); ?>" autocomplete="off" required />

        <label for="devise">Choisissez une devise.</label>

        <select name="devise" id="devise" required>
          <option value="" <?= $choixDeDevise === '' ? 'selected' : '' ?> disabled>Devises</option>

          <option value="euro" <?= $choixDeDevise === 'euro' ? 'selected' : '' ?>>Euro</option>
          <option value="dollar" <?= $choixDeDevise === 'dollar' ? 'selected' : '' ?>>Dollar américain</option>
          <option value="franc" <?= $choixDeDevise === 'franc' ? 'selected' : '' ?>>Franc CFA</option>
          <option value="livre" <?= $choixDeDevise === 'livre' ? 'selected' : '' ?>>Livre</option>
          <option value="franc_suisse" <?= $choixDeDevise === 'franc_suisse' ? 'selected' : '' ?>>Franc_suisse</option>
          <option value="yen" <?= $choixDeDevise === 'yen' ? 'selected' : '' ?>>Yen</option>
          <option value="dollar_canadien" <?= $choixDeDevise === 'dollar_canadien' ? 'selected' : '' ?>>Dollar_canadien</option>
          <option value="yuan" <?= $choixDeDevise === 'yuan' ? 'selected' : '' ?>>Yuan</option>
        </select>

        <br />

        <input type="submit" value="Poursuivons..." />
      </form>
    </div>
  </div>

  <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL"
    crossorigin="anonymous"></script>
</body>

</html>