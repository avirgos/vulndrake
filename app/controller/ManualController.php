<?php
namespace App\Controller;

require_once "/var/www/vulndrake/app/vendor/autoload.php";

class ManualController {
    public function executeScanner($ipAddress) {
        $containerName = "vulndrake-worker";
        $command = "docker exec -u gvm-user $containerName sh worker/scanner.sh $ipAddress 2>&1";
        $output = shell_exec($command);

        if (strpos($output, "Report saved as") !== false) {
            preg_match('/Report saved as (.*)$/', $output, $matches);
            $reportFile = trim($matches[1]);

            $reportName = basename($reportFile);

            return ["success" => true, "report_name" => $reportName];
        } else {
            return ["success" => false, "error" => "Report generation error"];
        }
    }
}
?>