<h2>Manuel</h2>

<form method="post" action="../vue/scanner.php">
    <div class="form-group">
        <label for="ip-address">Adresse IP :</label>
        <input type="text" id="ip-address" name="ip-address" required>
    </div>

    <div class="radio-group">
        <input type="radio" id="port-list1" name="port-list" value="730ef368-57e2-11e1-a90f-406186ea4fc5">
        <label for="port-list1">Tous les ports TCP (+65500) + top 100 des ports UDP utilisés par Nmap <span class="default-option">(option par défaut)</span></label>
    </div>
    <div class="radio-group">
        <input type="radio" id="port-list2" name="port-list" value="33d0cd82-57c6-11e1-8ed1-406186ea4fc5">
        <label for="port-list2">Tous les ports TCP (+5800) assignés par l'IANA</label>
    </div>
    <div class="radio-group">
        <input type="radio" id="port-list3" name="port-list" value="4a4717fe-57d2-11e1-9a26-406186ea4fc5">
        <label for="port-list3">Tous les ports TCP (+5800) et UDP (+5482) assignés par l'IANA</label>
    </div>
    
    <button type="submit" name="execute" disabled>Exécuter le scanner</button>
    <span id="status-message">Veuillez patienter... ⏲</span>
</form>