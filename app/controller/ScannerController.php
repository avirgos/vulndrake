<?php
namespace App\Controller;

require_once "ManualController.php";

class ScannerController {
    public function scanAndTransferReport($ipAddress, $selectedPortList) {
        $manualController = new ManualController();

        if (isset($selectedPortList)) {
            $selectedPortList = $selectedPortList;
        } else {
            $selectedPortList = "730ef368-57e2-11e1-a90f-406186ea4fc5";
        }

        if (filter_var($ipAddress, FILTER_VALIDATE_IP)) {
            $scanResult = $manualController->executeScanner($ipAddress, $selectedPortList);

            if ($scanResult["success"]) {
                echo "<h2>Scan réussi !</h2>";
                
                $pdfName = $scanResult["report_name"];

                $manualController->transferReport($pdfName);
                
                echo "<p><a href='/data/reports/{$pdfName}' target='_blank'>Cliquez ici pour voir le rapport PDF</a></p>";
            } else {
                echo "<h2>Erreur lors du scan</h2>";
                echo "<p>{$scanResult['error']}</p>";
            }
        } else {
            echo "<h2>Erreur</h2>";
            echo "<p>Adresse IP invalide. Veuillez entrer une adresse IP valide.</p>";
        }
    }
}
?>