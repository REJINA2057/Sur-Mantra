const selectedValue =document.getElementById("clientName");

selectedValue.addEventListener("change", function () {
    const [clientId, clientName] = selectedValue.value.split('|');

    if (clientId) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "php_action/fetchClientContact.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (xhr.status === 200) {
                const contact = xhr.responseText.trim();
                document.getElementById("clientContact").value = contact;
            }
        };

        xhr.send("client_id=" + encodeURIComponent(clientId));
    } else {
        document.getElementById("clientContact").value = "";
    }
});

