<h2>Manuel</h2>

<form method="post" action="../controller/execute_scanner.php">
    <label for="ip_address">Adresse IP à scanner :</label>
    <input type="text" id="ip_address" name="ip_address" required>
    <button type="submit" name="execute" disabled>Exécuter le scanner</button>
    <span id="status-message">Veuillez patienter... ⏲</span>
</form>