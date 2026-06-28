<?php

session_start();

require_once("../../Model/OrderModel.php");

$order = new OrderModel();

$conn = $order->OpenConn();

$items =
$order->GetOrderItems(
    $conn,
    $_GET['id']
);

?>

<!DOCTYPE html>
<html>
<head>

<title>

Order Details

</title>

</head>

<body>

<h1>

Order Items

</h1>

<table border="1">

<tr>

<th>Image</th>
<th>Product</th>
<th>Price</th>
<th>Qty</th>

</tr>

<?php

while(
$row =
$items->fetch_assoc()
)

{

?>

<tr>

<td>

<img
src="../../uploads/products/<?php echo $row['image']; ?>"
width="80">

</td>

<td>

<?php echo $row['product_name']; ?>

</td>

<td>

৳ <?php echo $row['price']; ?>

</td>

<td>

<?php echo $row['quantity']; ?>

</td>

</tr>

<?php

}

?>

</table>

</body>

</html>