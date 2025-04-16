<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$productName 		= $_POST['productName'];
	$defaultImage		= $_POST['defaultImage'];
  $quantity 			= $_POST['quantity'];
  $rate 					= $_POST['rate'];
  $supplierName 	= $_POST['supplierName'];
  $brandName 			= $_POST['brandName'];
  $categoryName 	= $_POST['categoryName'];
  $productStatus 	= $_POST['productStatus'];

	$productImageValue = $defaultImage; 

	if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
    // A file was uploaded
    $type = pathinfo($_FILES['productImage']['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid(rand()) . '.' . $type;
    $url = '../assests/images/stock/' . $newFileName;

    // Validate the image type
    if (in_array(strtolower($type), array('gif', 'jpg', 'jpeg', 'png'))) {
      if (move_uploaded_file($_FILES['productImage']['tmp_name'], $url)) {
        $productImageValue = $url; // set the actual uploaded path
      }
    }
  }

	// Final INSERT using either the uploaded file or the default string
	$sql = "INSERT INTO product (
							product_name, 
							product_image, 
							brand_id, 
							categories_id, 
							supplier_id, 
							quantity, 
							rate, 
							active, 
							status
						) 
					VALUES (
							'$productName', 
							'$productImageValue', 
							'$brandName', 
							'$categoryName',
							'$supplierName', 
							'$quantity', 
							'$rate', 
							1, 
							'$productStatus'
						)";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Successfully Added";	
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while adding the product";
	}

	$connect->close();

	echo json_encode($valid);
}
