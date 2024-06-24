<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VulnDrake | Accueil</title>
    <link rel="apple-touch-icon" sizes="180x180" href="data/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="data/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="data/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="data/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="data/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/manual.css">
    <link rel="stylesheet" href="css/automatic.css">
    <link rel="stylesheet" href="css/history.css">
    <script src="js/script.js"></script>
</head>
<body>
    <header>
        <img src="data/img/icons/vulndrake.png" alt="Icône VulnDrake" width="100" height="100" class="icon-vulndrake">
        <h1>VulnDrake</h1>
    </header>
    <section id="scanner">
        <div class="manual">
            <?php include "./vue/manual.php"; ?>
        </div>
        <div class="automatic">
            <?php include "./vue/automatic.php"; ?>
        </div>
    </section>
    <div id="history">
        <?php include "./vue/history.php"; ?>
    </div>
    <footer>
        <p>© 2024 Antoine Virgos</p>
    </footer>
</body>
</html>