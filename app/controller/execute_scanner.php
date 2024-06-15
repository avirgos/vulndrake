<?php
require_once "ManualController.php";

$manualController = new \App\Controller\ManualController();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["execute"])) {
    $ipAddress = $_POST["ip_address"];
    $result = $manualController->executeScanner($ipAddress);

    if ($result["success"]) {
        echo "<h3>Scan réussi !</h3>";

        # TODO : conversion XML -> PDF
        echo "<embed src=\"{$result['report_url']}\" type=\"application/pdf\" width=\"100%\" height=\"600px\">";
    } else {
        echo "<h3>Erreur lors du scan :</h3>";
        echo "<p>{$result['error']}</p>";
    }
}
?>