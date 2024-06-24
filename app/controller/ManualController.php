<?php
namespace App\Controller;

class ManualController {
    public function executeScanner($ipAddress, $selectedPortList) {
        $containerName = "vulndrake-worker";
        $command = escapeshellcmd("docker exec -u gvm-user $containerName sh worker/scanner.sh $ipAddress $selectedPortList 2>&1");
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

    public function transferReport($reportName) {
        $sourceContainer = "vulndrake-worker";
        $destinationContainer = "vulndrake-web";
        $sourcePath = escapeshellarg("/worker/$reportName");
        $destinationPath = escapeshellarg("/var/www/vulndrake/app/data/reports/$reportName");

        // from vulndrake-worker to the host
        $hostTempPath = "/tmp/$reportName";
        $command = escapeshellcmd("docker cp $sourceContainer:$sourcePath $hostTempPath");
        $output1 = shell_exec($command);

        // from the host to vulndrake-web
        $command = escapeshellcmd("docker cp $hostTempPath $destinationContainer:$destinationPath");
        $output2 = shell_exec($command);

        unlink($hostTempPath);

        if ($output1 === null && $output2 === null) {
            // remove the report file from vulndrake-worker
            $command = escapeshellcmd("docker exec $sourceContainer rm $sourcePath");
            shell_exec($command);

            return ["success" => true];
        } else {
            return ["success" => false, "error" => "Failed to copy report to web container"];
        }
    }
}
?>