<?php

namespace App\Controller;

class ManualController {
    public function executeScanner() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["execute"])) {
            $containerName = "vulndrake-worker";
            $command = "docker exec -u gvm-user $containerName sh worker/scanner.sh 2>&1";
            $output = shell_exec($command);
            echo "<pre>$output</pre>";
        }
    }
}
?>