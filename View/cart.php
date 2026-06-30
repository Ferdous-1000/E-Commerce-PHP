```php
<?php

session_start();

if(!isset($_SESSION['id']))
{
    header("Location: login.php");
    exit();
}

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

<link rel="stylesheet" href="../CSS/navbar.css">

<style>

body{
    margin:0;
    background:#f4f7fc;
    font-family:Arial,sans-serif;
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

img{
    width:80px;
    height:80px;
    object-fit:cover;
}

.qty-input{
    width:70px;
    padding:6px;
    text-align:center;
}

.update-btn{
    background:#2563eb;
    color:white;
    border:none;
    padding:8px 12px;
    cursor:pointer;
    border-radius:4px;
}

.remove-btn{
    background:#dc2626;
    color:white;
    padding:8px 12px;
    text-decoration:none;
    border-radius:4px;
}

.total-box{
    margin-top:20px;
    text-align:right;
}

.checkout-btn{
    display:inline-block;
    background:#16a34a;
    color:white;
    text-decoration:none;
    padding:12px 20px;
    border-radius:5px;
}

.empty{
    text-align:center;
    background:white;
    padding:40px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

</style>

</head>

<body>

<?php include("layout/navbar.php"); ?>

<div class="container">

<h1>My Cart</h1>

<?php

if($items->num_rows == 0)
{

?>

<div class="empty">

<h2>Your Cart Is Empty</h2>

<p>

Browse products and add items.

</p>

<a
class="checkout-btn"
href="products.php">

Continue Shopping

</a>

</div>

<?php

}
else
{

?>

<table>

<tr>

<th>Image</th>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
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
src="../uploads/products/<?php echo $row['image']; ?>">

</td>

<td>

<?php echo $row['product_name']; ?>

</td>

<td>

৳ <?php echo $row['price']; ?>

</td>

<td>

<form
method="POST"
action="../Controller/CartController.php">

<input
type="hidden"
name="cart_id"
value="<?php echo $row['id']; ?>">

<input
class="qty-input"
type="number"
name="quantity"
min="1"
value="<?php echo $row['quantity']; ?>">

<button
type="submit"
name="updateCart"
class="update-btn">

Update

</button>

</form>

</td>

<td>

৳ <?php echo $subtotal; ?>

</td>

<td>

<a
class="remove-btn"
onclick="return confirm('Remove this item?')"
href="../Controller/CartController.php?remove=<?php echo $row['id']; ?>">

Remove

</a>

</td>

</tr>

<?php

}

?>

</table>

<div class="total-box">

<h2>

Grand Total:
৳ <?php echo $total; ?>

</h2>

<br>

<a
class="checkout-btn"
href="../Controller/CheckoutController.php">

Place Order

</a>

</div>

<?php

}

?>

</div>

</body>

</html>
```
