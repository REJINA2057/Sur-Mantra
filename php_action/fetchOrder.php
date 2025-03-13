<?php
require_once 'core.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "SELECT order_id, order_date, client_name, client_contact, payment_status FROM orders WHERE order_status = 1";
$result = $connect->query($sql);

$output = array('data' => array());

if ($result && $result->num_rows > 0) {
    $x = 1;

    while ($row = $result->fetch_array()) {
        $orderId = $row[0];

        // Fetch order item count
        $orderItemSql = "SELECT count(*) FROM order_item WHERE order_id = $orderId";
        $orderitemResult = $connect->query($orderItemSql);
        $orderItemRow = $orderitemResult ? $orderitemResult->fetch_row() : [0];

        // Fetch retail price details
        $retailPriceSql = "SELECT retail_price, rate FROM order_item WHERE order_id = $orderId";
        $retailPriceResult = $connect->query($retailPriceSql);
        $retailPriceRow = $retailPriceResult ? $retailPriceResult->fetch_row() : [0, 0];

        $countItem = $orderItemRow[0];
        $retailPrice = $retailPriceRow[0] ?? 0; // Ensure valid value
        $rate = $retailPriceRow[1] ?? 0;

        // Calculate Retail Price - Rate
        $finalPrice = $retailPrice - $rate;

				$priceColor = $finalPrice < 0 ? "red" : "green";

				$indicator = $finalPrice < 0 ? "-":"+";

        // Payment status formatting
        if ($row[4] == 1) { 		
            $paymentStatus = "<label class='label label-success'>Full Payment</label>";
        } elseif ($row[4] == 2) { 		
            $paymentStatus = "<label class='label label-info'>Advance Payment</label>";
        } else { 		
            $paymentStatus = "<label class='label label-warning'>No Payment</label>";
        }

        // Retail Price displayed before the Action Button
        $retailPriceDisplay = '<p style="margin-bottom:3px; font-size:12px; color:'.$priceColor.';  text-align:right;">'.$indicator.' Rs'.$finalPrice.'</p>';

        // Action buttons
        $button = '
        <div class="btn-group" style="padding:5px;">
					'.$retailPriceDisplay.'
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action<span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="orders.php?o=editOrd&i='.$orderId.'" id="editOrderModalBtn"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
                <li><a type="button" data-toggle="modal" id="paymentOrderModalBtn" data-target="#paymentOrderModal" onclick="paymentOrder('.$orderId.')"> <i class="glyphicon glyphicon-save"></i> Payment</a></li>
                <li><a type="button" onclick="printOrder('.$orderId.')"> <i class="glyphicon glyphicon-print"></i> Print </a></li>
                <li><a type="button" data-toggle="modal" data-target="#removeOrderModal" id="removeOrderModalBtn" onclick="removeOrder('.$orderId.')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>       
            </ul>
        </div>';		

        $output['data'][] = array( 		
            $x,
            $row[1],  // Order date
            $row[2],  // Client name
            $row[3],  // Client contact
            $countItem, 
            $paymentStatus,
            $button
        ); 	

        $x++;
    }
}

// Close connection
$connect->close();

// Ensure valid JSON
header('Content-Type: application/json');
$jsonOutput = json_encode($output);
if (json_last_error() != JSON_ERROR_NONE) {
    die("JSON Encode Error: " . json_last_error_msg());
}

echo $jsonOutput;
?>
