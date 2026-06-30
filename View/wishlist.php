<?php

session_start();

if(!isset($_SESSION['id']))
{
    header("Location: login.php");
    exit();
}

require_once("../Model/WishlistModel.php");

$wishlist = new WishlistModel();

$conn = $wishlist->OpenConn();

$items = $wishlist->GetWishlist(
    $conn,
    $_SESSION['id']
);

?>

<!DOCTYPE html>
<html>

<head>

<title>My Wishlist</title>

<link rel="stylesheet" href="../CSS/navbar.css">

<style>

body{
    margin:0;
    background:#f4f7fc;
    font-family:Arial,sans-serif;
}

.container{
    width:95%;
    max-width:1200px;
    margin:30px auto;
}

h1{
    text-align:center;
    color:#1e3a8a;
}

.summary{
    background:white;
    padding:15px;
    margin-bottom:20px;
    border-radius:8px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
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
    border-radius:6px;
}

.btn{
    padding:8px 15px;
    text-decoration:none;
    color:white;
    border-radius:5px;
    display:inline-block;
    margin:2px;
}

.view-btn{
    background:#2563eb;
}

.cart-btn{
    background:green;
}

.remove-btn{
    background:red;
}

.empty{
    text-align:center;
    padding:50px;
    background:white;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.empty h2{
    color:#1e3a8a;
}
.btn {
    cursor: pointer;
}
</style>

</head>

<body>

<?php include("layout/navbar.php"); ?>

<div class="container">

<h1>My Wishlist</h1>

<?php

if($items && $items->num_rows > 0)
{

?>

<div class="summary">

<strong>
Total Wishlist Items:
</strong>

<?php echo $items->num_rows; ?>

</div>

<table>

<tr>
    <th>Image</th>
    <th>Product</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Actions</th>
</tr>

<?php

while($row = $items->fetch_assoc())
{

?>

<tr>

<td>

<img
src="../uploads/products/<?php echo $row['image']; ?>"
alt="Product">

</td>

<td>

<?php echo htmlspecialchars($row['product_name']); ?>

</td>

<td>

৳ <?php echo number_format($row['price'],2); ?>

</td>

<td>

<?php

if($row['stock'] > 0)
{
    echo $row['stock'];
}
else
{
    echo "<span style='color:red;'>Out Of Stock</span>";
}

?>

</td>

<td>

<a
class="btn view-btn"
href="product_details.php?id=<?php echo $row['product_id']; ?>">

View

</a>

<?php

if($row['stock'] > 0)
{

?>

<form method="POST" action="../Controller/CartController.php" style="display:inline;">

    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">

    <input type="hidden" name="quantity" value="1">

    <button type="submit" name="addToCart" class="btn cart-btn">

        Add To Cart

    </button>

</form>
<?php

}

?>

<a
class="btn remove-btn"
href="../Controller/WishlistController.php?remove=<?php echo $row['id']; ?>"
onclick="return confirm('Remove this item from wishlist?')">

Remove

</a>

</td>

</tr>

<?php

}

?>

</table>

<?php

}
else
{

?>

<div class="empty">

<h2>Your Wishlist Is Empty</h2>

<p>

You have not added any products yet.

</p>

<br>

<a
href="products.php"
class="btn view-btn">

Browse Products

</a>

</div>

<?php

}

?>

</div>

</body>

</html>

<?php

$wishlist->CloseConn($conn);

?>