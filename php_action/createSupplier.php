<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$supplierName = $_POST['supplierName'];
  $supplierStatus = $_POST['supplierStatus']; 

	$sql = "INSERT INTO supplier (supplier_name, active, supplier_status) VALUES ('$supplierName',1,'$supplierStatus')";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Added";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}
	 

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST