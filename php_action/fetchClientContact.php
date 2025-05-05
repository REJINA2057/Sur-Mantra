<?php
require 'core.php';

if (isset($_POST['client_id'])) {
    $clientId = intval($_POST['client_id']); // Securely get the client ID

    $stmt = $connect->prepare("SELECT client_phone_no FROM clients WHERE client_id = ?");
    $stmt->bind_param("i", $clientId);
    $stmt->execute();
    $stmt->bind_result($contact);
    $stmt->fetch();
    $stmt->close();

    echo $contact ?? 'Not found'; // Send contact back to client.js
}
?>