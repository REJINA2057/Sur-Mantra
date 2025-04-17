<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {

	$supplierName = $_POST['supplierName'];
	$supplierPhone = $_POST['supplierPhone'];
	$supplierStatus = $_POST['supplierStatus'];
	$supplierAddress = $_POST['supplierAddress'];

	$sql = "INSERT INTO supplier (supplier_name, supplier_active, phone_no, supplier_address, supplier_status) VALUES ('$supplierName',1,'$supplierPhone','$supplierAddress','$supplierStatus')";

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