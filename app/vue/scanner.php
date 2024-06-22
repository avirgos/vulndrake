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
</head>
<body>
    <?php
    require_once "../controller/ScannerController.php";

    use App\Controller\ScannerController;

    $scannerController = new ScannerController();

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["execute"])) {
        $ipAddress = $_POST["ip-address"];
        $selectedPortList = $_POST["port-list"];
        
        $scannerController->scanAndTransferReport($ipAddress, $selectedPortList);
    }
    ?>

    <a href="/">Retour à la page principale</a>
</body>
</html>