<?php
header("Content-Type: application/json");

$containerName = "vulndrake-worker";
$command = "docker exec -u gvm-user $containerName sh worker/check-connection.sh 2>&1";
$output = shell_exec($command);

if (strpos($output, "VulnDrake connected to socket.") !== false) {
    echo json_encode(["status" => "connected"]);
} else {
    echo json_encode(["status" => "not_connected"]);
}
?>