<?php 	

require_once 'core.php';

$sql = "SELECT supplier_id, supplier_name, active, supplier_status FROM supplier WHERE supplier_status = 1";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $activeBrands = ""; 

 while($row = $result->fetch_array()) {
 	$supplierId = $row[0];
 	// active 
 	if($row[2] == 1) {
 		// activate member
 		$activeSupplier = "<label class='label label-success'>Available</label>";
 	} else {
 		// deactivate member
 		$activeSupplier = "<label class='label label-danger'>Not Available</label>";
 	}

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" data-target="#editSupplierModel" onclick="editBrands('.$supplierId.')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeSupplierMemberModal" onclick="removeSupplier('.$supplierId.')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>       
	  </ul>
	</div>';

 	$output['data'][] = array( 		
 		$row[1], 		
 		$activeSupplier,
 		$button
 		); 	
 } // /while 

} // if num_rows

$connect->close();

echo json_encode($output);