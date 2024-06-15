<?php
require_once "ManualController.php";

$manualController = new \App\Controller\ManualController();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["execute"])) {
    $ipAddress = $_POST["ip_address"];
    $scanResult = $manualController->executeScanner($ipAddress);

    if ($scanResult["success"]) {
        echo "<h3>Scan réussi !</h3>";

        $xmlFile = "/var/www/vulndrake/" . $scanResult["report_url"];
        $xmlFileName = $scanResult["report_name"];
        $pdf = $manualController->convertXmlToPdf($xmlFile, $xmlFileName);
        echo "<embed src=\"{$pdf}\" type=\"application/pdf\" width=\"100%\" height=\"600px\">";
    } else {
        echo "<h3>Erreur lors du scan :</h3>";
        echo "<p>{$scanResult['error']}</p>";
    }
}
?>