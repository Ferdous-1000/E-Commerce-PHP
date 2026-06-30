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

$orders =
$order->GetOrdersByUser(
    $conn,
    $_SESSION['id']
);

?>

<!DOCTYPE html>
<html>

<head>

<title>My Orders</title>

<link rel="stylesheet" href="../CSS/navbar.css">
<link rel="stylesheet" href="../CSS/orders.css">

<style>

body{
    font-family:Arial,sans-serif;
    background:#f4f7fc;
    margin:0;
}

.container{
    width:95%;
    margin:20px auto;
}

h1{
    text-align:center;
    color:#1e3a8a;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

th{
    background:#2563eb;
    color:white;
    padding:12px;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

.status{
    padding:6px 12px;
    border-radius:5px;
    color:white;
    font-size:14px;
}

.pending{
    background:orange;
}

.processing{
    background:#2563eb;
}

.shipped{
    background:purple;
}

.delivered{
    background:green;
}

.details-btn{
    background:#2563eb;
    color:white;
    text-decoration:none;
    padding:8px 15px;
    border-radius:5px;
}

.details-btn:hover{
    background:#1d4ed8;
}

</style>

</head>

<body>

<?php include("layout/navbar.php"); ?>

<div class="container">

<h1>My Orders</h1>

<table>

<tr>

<th>Order ID</th>
<th>Total</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>

</tr>

<?php

if($orders->num_rows == 0)
{
?>
<tr>
<td colspan="5">
No orders found.
</td>
</tr>
<?php
}
else
{
    while($row = $orders->fetch_assoc())
{
    $statusClass = strtolower($row['status']);
?>

<tr>

<td>
#<?php echo $row['id']; ?>
</td>

<td>
৳ <?php echo number_format($row['total_amount'], 2); ?>
</td>

<td>

<span class="status <?php echo $statusClass; ?>">

<?php echo $row['status']; ?>

</span>

</td>

<td>
<?php echo $row['created_at']; ?>
</td>

<td>

<a
class="details-btn"
href="order_details.php?id=<?php echo $row['id']; ?>">

View Details

</a>

</td>

</tr>

<?php
    }
}
?>
</table>

</div>

</body>

</html>