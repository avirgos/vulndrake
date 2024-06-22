function checkConnection(statusMessage, executeButton) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../controller/check_connection.php", true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            if (response.status === "connected") {
                executeButton.disabled = false;
                statusMessage.textContent = "VulnDrake est prêt à être utilisé ! ✅";
            } else if (response.status === "not_connected") {
                executeButton.disabled = true;
                statusMessage.textContent = "Veuillez patienter... ⏲";

                setTimeout(function() {
                    checkConnection(statusMessage, executeButton);
                }, 5000);
            }
        }
    };

    xhr.send();
}

document.addEventListener("DOMContentLoaded", function() {
    const statusMessage = document.getElementById("status-message");
    const executeButton = document.querySelector('button[name="execute"]');

    executeButton.disabled = true;

    checkConnection(statusMessage, executeButton);
});
