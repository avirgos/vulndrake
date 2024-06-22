<h2>Historique</h2>

<?php
$reportDir = __DIR__ . '/../data/reports';
$files = scandir($reportDir);

$reports = [];

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === "pdf") {
        if (preg_match('/VulnDrake-Report-(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})-\d+\.pdf/', $file, $matches)) {
            $timestamp = "{$matches[1]}-{$matches[2]}-{$matches[3]} {$matches[4]}:{$matches[5]}:{$matches[6]}";
            $date = "{$matches[3]}/{$matches[2]}/{$matches[1]} {$matches[4]}:{$matches[5]}:{$matches[6]}";

            $reports[] = [
                "file" => $file,
                "timestamp" => $timestamp,
                "date" => $date
            ];
        }
    }
}

usort($reports, function($a, $b) {
    return strtotime($b["timestamp"]) - strtotime($a["timestamp"]);
});

if (empty($reports)) {
    echo "<p>Aucun rapport n'a été trouvé.</p>";
} else {
    echo "<ul>";
    foreach ($reports as $report) {
        $filePath = "/data/reports/{$report['file']}";

        echo "<li>";
        echo "<a href='$filePath' target='_blank'>{$report['file']}</a> - {$report['date']} ";
        echo "<form method='post' action='/controller/delete_report.php' style='display: inline;'>";
        echo "<input type='hidden' name='file' value='{$report['file']}'>";
        echo "</form>";
        echo "</li>";
    }
    echo "</ul>";
}
?>