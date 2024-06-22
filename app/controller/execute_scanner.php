<?php
require_once "ManualController.php";

$manualController = new \App\Controller\ManualController();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["execute"])) {
    $ipAddress = $_POST["ip_address"];

    if (filter_var($ipAddress, FILTER_VALIDATE_IP)) {
        $scanResult = $manualController->executeScanner($ipAddress);

        if ($scanResult["success"]) {
            echo "<h3>Scan réussi !</h3>";
            
            $pdfName = $scanResult["report_name"];

            $manualController->transferReport($pdfName);
            
            echo "<p><a href='/data/reports/{$pdfName}' target='_blank'>Cliquez ici pour voir le rapport PDF</a></p>";
        } else {
            echo "<h3>Erreur lors du scan :</h3>";
            echo "<p>{$scanResult['error']}</p>";
        }
    } else {
        echo "<h3>Erreur :</h3>";
        echo "<p>Adresse IP invalide. Veuillez entrer une adresse IP valide.</p>";
    }
}
?>

<a href="/">Retour à la page principale</a>