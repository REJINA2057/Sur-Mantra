<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {

  $newClientName = $_POST['newClientName'];
  $newClientStatus = $_POST['newClientStatus'];
  $newClientAddress = $_POST['newClientAddress'];
  $newClientPhoneNo = $_POST['newClientPhoneNo'];

  $sql = "INSERT INTO clients (client_name, client_active, client_status,client_phone_no,client_address) VALUES ('$newClientName', '$newClientStatus', 1,'$newClientPhoneNo','$newClientAddress')";

  if ($connect->query($sql) === TRUE) {
    $valid['success'] = true;
    $valid['messages'] = "Successfully Added";
  } else {
    $valid['success'] = false;
    $valid['messages'] = "Error while adding the members";
  }


  $connect->close();

  echo json_encode($valid);

} // /if $_POST