<?php

session_start();

require_once("../Model/CartModel.php");

$cart = new CartModel();

$conn = $cart->OpenConn();

$items =
$cart->GetCartItems(
    $conn,
    $_SESSION['id']
);

$total = 0;

?>

<!DOCTYPE html>
<html>
<head>
<title>Shopping Cart</title>
</head>

<body>
<?php include("layout/navbar.php"); ?>
<h1>My Cart</h1>

<table border="1">

<tr>
<th>Image</th>
<th>Name</th>
<th>Price</th>
<th>Qty</th>
<th>Subtotal</th>
<th>Action</th>
</tr>

<?php

while($row = $items->fetch_assoc())
{
    $subtotal =
    $row['price']
    *
    $row['quantity'];

    $total += $subtotal;
?>

<tr>

<td>

<img
src="../uploads/products/<?php echo $row['image']; ?>"
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

<td>
৳ <?php echo $subtotal; ?>
</td>

<td>

<a href="../Controller/CartController.php?remove=<?php echo $row['id']; ?>">

Remove

</a>

</td>

</tr>

<?php
}
?>

</table>

<h2>

Total:
৳ <?php echo $total; ?>

</h2>

<a href="../Controller/CheckoutController.php">
Place Order
</a>

</a>

</body>

</html>