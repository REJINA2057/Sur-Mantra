<?php
require_once 'core.php';

$orderId = $_POST['orderId'];

$sql = "SELECT order_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due, payment_type, payment_place FROM orders WHERE order_id = $orderId";
$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderDate = $orderData[0];
$clientName = $orderData[1];
$clientContact = $orderData[2];
$subTotal = $orderData[3];
$vat = $orderData[4];
$grandTotal = $orderData[7];
$pmt = $orderData[11];
$pmt_type = $orderData[10];
 if($pmt_type == 1){
   $pmt_type = "Cheque";
 }
 elseif($pmt_type == 2){
   $pmt_type = "Cash";
 }
 else{
   $pmt_type = "Credit";
 }

$orderItemSql = "SELECT order_item.product_id, order_item.retail_price, order_item.quantity, order_item.total, product.product_name 
FROM order_item
INNER JOIN product ON order_item.product_id = product.product_id 
WHERE order_item.order_id = $orderId";
$orderItemResult = $connect->query($orderItemSql);

echo '
<style>
    body { font-family: Arial, sans-serif; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: center; }
    .no-border { border: none; }
    .text-left { text-align: left; }
</style>
<div class="header-left">
        <img src="../assests/images/logo.png" class="logo" alt="Company Logo">
<div>

<h2 style="text-align:center;">Aasaya Enterprises</h2>
<p style="text-align:center;">Kathmandu, Nepal</p>
<h3 style="text-align:center;">Tax Invoice</h3>

<table>
    <tr>
        <td class="text-left"><strong>VAT No:</strong> </td>
        <td class="text-left"><strong>Date:</strong> '.$orderDate.'</td>
    </tr>
    <tr>
        <td class="text-left"><strong>Buyer\'s Name:</strong> '.$clientName.'</td>
        <td class="text-left"><strong>Invoice No:</strong> '.$orderId.'</td>
    </tr>
    <tr>
        <td class="text-left"><strong>Address:</strong> '.$pmt.'</td>
    </tr>
    <tr>
        <td class="text-left"><strong>Mode of Payment:</strong> '.$pmt_type.'</td>
        <td></td>
    </tr>
</table>

<table>
    <tr>
        <th>S.N.</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Rate</th>
        <th>Amount (Rs.)</th>
    </tr>';

    $x = 1;
    while($row = $orderItemResult->fetch_array()) {
        echo '
        <tr>
            <td>'.$x.'</td>
            <td>'.$row['product_name'].'</td>
            <td>'.$row['quantity'].'</td>
            <td>'.$row['retail_price'].'</td>
            <td>'.$row['total'].'</td>
        </tr>';
        $x++;
    }

$amountInWords = ucwords(number_format($grandTotal, 2, '.', ''));
// Example conversion can be improved with a proper number-to-words function

echo '
</table>

<table>
    <tr>
        <td colspan="5" class="text-left"><strong>Total</strong></td>
        <td>'.$subTotal.'</td>
    </tr>
    <tr>
        <td colspan="5" class="text-left"><strong>Taxable Amount</strong></td>
        <td>'.$subTotal.'</td>
    </tr>
    <tr>
        <td colspan="5" class="text-left"><strong>12% VAT</strong></td>
        <td>'.$vat.'</td>
    </tr>
    <tr>
        <td colspan="5" class="text-left"><strong>Grand Total</strong></td>
        <td>'.$grandTotal.'</td>
    </tr>
</table>

<p><strong>In words:</strong> '.$amountInWords.' Rupees only</p>

<p style="text-align:left;">* E & O.E</p>
<p style="text-align:right;">For, Aasaya Enterprises</p>
<p style="text-align:right;">[Signature]</p>
';

$connect->close();
?>
