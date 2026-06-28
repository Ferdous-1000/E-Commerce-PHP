<?php

include("../Model/ProductModel.php");

$product = new ProductModel();

$conn = $product->OpenConn();

$result =
$product->GetProductById(
$conn,
$_GET['id']
);

$row =
$result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
<head>

<title>

<?php echo $row['product_name']; ?>

</title>

</head>

<body>

<h1>

<?php echo $row['product_name']; ?>

</h1>

<img
width="300"
src="../uploads/products/<?php echo $row['image']; ?>">

<p>

<?php echo $row['description']; ?>

</p>

<h2>

৳ <?php echo $row['price']; ?>

</h2>

<p>

Stock:
<?php echo $row['stock']; ?>

</p>

<a href="../Controller/CartController.php?add=<?php echo $row['id']; ?>">

Add To Cart

</a>

</body>
</html>