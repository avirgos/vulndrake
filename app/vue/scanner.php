<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VulnDrake | Scanner</title>
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