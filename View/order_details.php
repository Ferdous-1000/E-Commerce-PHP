<?php

session_start();

if(!isset($_SESSION['id']))
{
    header("Location: login.php");
    exit();
}

require_once("../Model/OrderModel.php");

$order = new OrderModel();

$conn = $order->OpenConn();

if(!isset($_GET['id']))
{
    header("Location: orders.php");
    exit();
}

$orderId = $_GET['id'];

$orderData =
$order->GetOrderById(
    $conn,
    $orderId
);

if($orderData->num_rows == 0)
{
    die("Order Not Found");
}

$orderInfo =
$orderData->fetch_assoc();

/*
Security Check
User can only view own orders
*/

if(
    $orderInfo['user_id']
    !=
    $_SESSION['id']
)
{
    die("Access Denied");
}

$items =
$order->GetOrderItems(
    $conn,
    $orderId
);

?>

<!DOCTYPE html>
<html>

<head>

<title>

Order Details

</title>

<link rel="stylesheet" href="../CSS/navbar.css">
<link rel="stylesheet" href="../CSS/order_details.css">



</head>

<body>

<?php include("layout/navbar.php"); ?>

<div class="container">

<div class="order-box">

<h2>

Order #<?php echo $orderInfo['id']; ?>

</h2>

<p>

Order Date:
<?php echo $orderInfo['created_at']; ?>

</p>

<p>

Status:

<span
class="status <?php echo strtolower($orderInfo['status']); ?>">

<?php echo $orderInfo['status']; ?>

</span>

</p>

</div>

<table>

<tr>

<th>Image</th>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
<th>Subtotal</th>

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
src="../uploads/products/<?php echo $row['image']; ?>">

</td>

<td>

<?php echo $row['product_name']; ?>

</td>

<td>

 ৳ <?php echo number_format($row['price'],2); ?>

</td>

<td>

<?php echo $row['quantity']; ?>

</td>

<td>

৳
<?php
echo number_format(
    $row['price']
    *
    $row['quantity'],
    2
);
?>

</td>

</tr>

<?php

}

?>

</table>

<div class="total">

Total:
৳ <?php echo number_format($orderInfo['total_amount'],2); ?>

</div>

<a
class="back-btn"
href="orders.php">

Back To Orders

</a>

</div>

</body>

</html>