<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VulnDrake | Scanner</title>
    <link rel="apple-touch-icon" sizes="180x180" href="data/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="data/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="data/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="data/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="data/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/scanner.css">
</head>
<body>
    <header>
        <img src="../data/img/icons/vulndrake.png" alt="Icône VulnDrake" width="100" height="100" class="icon-vulndrake">
        <h1>VulnDrake</h1>
    </header>
    <div class="scan-report">
        <?php
        require_once "../controller/ScannerController.php";

        use App\Controller\ScannerController;

        $scannerController = new ScannerController();

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["execute"])) {
            $ipAddress = $_POST["ip-address"];
            $selectedPortList = isset($_POST["port-list"]) ? $_POST["port-list"] : null;
            
            $scannerController->scanAndTransferReport($ipAddress, $selectedPortList);
        }
        ?>
    </div>
    <a href="/" id="home-button">Retour à la page principale</a>
    <footer>
        <p>© 2024 Antoine Virgos</p>
    </footer>
</body>
</html>