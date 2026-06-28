<?php

session_start();

require_once("../Model/OrderModel.php");

$order = new OrderModel();

$conn = $order->OpenConn();

$orders =
$order->GetOrdersByUser(
    $conn,
    $_SESSION['id']
);

?>

<h1>My Orders</h1>

<table border="1">

<tr>

<th>ID</th>
<th>Total</th>
<th>Status</th>
<th>Date</th>

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
৳ <?php echo $row['total_amount']; ?>
</td>

<td>
<?php echo $row['status']; ?>
</td>

<td>
<?php echo $row['created_at']; ?>
</td>

</tr>

<?php
}
?>

</table>