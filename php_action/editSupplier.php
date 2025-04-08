<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$supplierName = $_POST['editSupplierName'];
  $supplierStatus = $_POST['editSupplierStatus']; 
  $supplierId = $_POST['supplierId'];

	$sql = "UPDATE supplier SET supplier_name = '$supplierName', active = '$supplierStatus' WHERE supplier_id = '$supplierId'";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST