<h2>Historique 📜</h2>

<?php
require_once __DIR__ . '/../controller/HistoryController.php';

use App\Controller\HistoryController;

$controller = new HistoryController();
$controller->displayReports();
?>