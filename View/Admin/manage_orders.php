<?php

session_start();

if(
!isset($_SESSION['role'])
||
$_SESSION['role'] != 'admin'
)
{
    header("Location: ../login.php");
    exit();
}

require_once("../../Model/OrderModel.php");

$order = new OrderModel();

$conn = $order->OpenConn();

$orders =
$order->GetAllOrders($conn);

?>

<!DOCTYPE html>
<html>
<head>

<title>

Manage Orders

</title>

<style>

body{
    font-family:Arial;
    margin:30px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    border:1px solid #ddd;
    padding:10px;
}

select{
    padding:5px;
}

button{
    padding:5px 10px;
}

</style>

</head>

<body>

<h1>

Manage Orders

</h1>

<table>

<tr>

<th>ID</th>
<th>Customer</th>
<th>Email</th>
<th>Total</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>
<th>Details</th>

</tr>

<?php

while(
$row =
$orders->fetch_assoc()
)

{

?>

<tr>

<td>

<?php echo $row['id']; ?>

</td>

<td>

<?php echo $row['name']; ?>

</td>

<td>

<?php echo $row['email']; ?>

</td>

<td>

৳ <?php echo $row['total_amount']; ?>

</td>

<td>

<?php echo $row['status']; ?>

</td>

<td>

<?php echo $row['created_at']; ?>

</td>

<td>

<form
action="../../Controller/AdminOrderController.php"
method="POST">

<input
type="hidden"
name="order_id"
value="<?php echo $row['id']; ?>">

<select name="status">

<option>Pending</option>

<option>Processing</option>

<option>Shipped</option>

<option>Delivered</option>

<option>Cancelled</option>

</select>

<button
type="submit"
name="updateStatus">

Update

</button>

</form>

</td>

<td>

<a href="order_details.php?id=<?php echo $row['id']; ?>">

View

</a>

</td>

</tr>

<?php

}

?>

</table>

</body>

</html>