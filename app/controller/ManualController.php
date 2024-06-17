<?php
namespace App\Controller;

require_once "/var/www/vulndrake/app/vendor/autoload.php";

use TCPDF;

class ManualController {
    public function executeScanner($ipAddress) {
        $containerName = "vulndrake-worker";
        $command = "docker exec -u gvm-user $containerName sh worker/scanner.sh $ipAddress 2>&1";
        $output = shell_exec($command);

        if (strpos($output, "Report saved as") !== false) {
            preg_match('/Report saved as (.*)$/', $output, $matches);
            
            if (isset($matches[1])) {
                $reportFile = trim($matches[1]);
                $reportUrl = "/worker/reports/" . basename($reportFile);
        
                return ["success" => true, "report_url" => $reportUrl, "report_name" => basename($reportFile)];
            } else {
                return ["success" => false, "error" => "Le chemin du fichier de rapport n'a pas été trouvé dans la sortie."];
            }
        } else {
            return ["success" => false, "error" => "Erreur de génération du rapport."];
        }        
    }

    public function convertXmlToPdf($xmlFile, $xmlFileName) {
        try {
            $pdf = new TCPDF();

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor("VulnDrake");
            $pdf->SetTitle("Rapport de Scan VulnDrake");
            $pdf->SetSubject("Conversion XML en PDF");
            $pdf->SetKeywords("TCPDF, PDF, XML, VulnDrake, Conversion");

            $pdf->AddPage();

            $xmlContent = file_get_contents($xmlFile);

            $pdf->SetFont("times", "", 12);
            $pdf->Write(0, $xmlContent, "", 0, "L", true, 0, false, false, 0);

            $fileInfo = pathinfo($xmlFileName);
            $pdfFileName = $fileInfo["filename"] . ".pdf";
            $pdfFilePath = "/var/www/vulndrake/worker/reports/" . $pdfFileName;

            $pdf->Output($pdfFilePath, "F");

            return $pdfFilePath;
        } catch (\Exception $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }
}
?>