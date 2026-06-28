<?php

session_start();

require_once("../Model/ProductModel.php");
require_once("../Model/CategoryModel.php");

$productModel =
new ProductModel();

$categoryModel =
new CategoryModel();

$conn =
$productModel->OpenConn();

$keyword =
$_GET['keyword'] ?? '';

$category_id =
$_GET['category_id'] ?? '';

$sort =
$_GET['sort'] ?? '';

$products =
$productModel->SearchProducts(
    $conn,
    $keyword,
    $category_id,
    $sort
);

$categories =
$categoryModel->GetCategories($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>

    <link rel="stylesheet"
    href="../CSS/products.css">
</head>
<body>
<div class="search-box">

<form method="GET">

<input
type="text"
name="keyword"
placeholder="Search Product"
value="<?php echo $keyword; ?>">

<select name="category_id">

<option value="">
All Categories
</option>

<?php

while($cat =
$categories->fetch_assoc())
{

?>

<option
value="<?php echo $cat['id']; ?>"

<?php

if($category_id ==
$cat['id'])
{
    echo "selected";
}

?>

>

<?php
echo $cat['category_name'];
?>

</option>

<?php

}

?>

</select>

<select name="sort">

<option value="">
Newest
</option>

<option value="price_low">
Price Low → High
</option>

<option value="price_high">
Price High → Low
</option>

</select>

<button type="submit">
Search
</button>

</form>

</div>
<nav>

<a href="index.php">Home</a>

<a href="products.php">Products</a>

<a href="cart.php">Cart</a>

<a href="../Controller/LogoutController.php">
Logout
</a>

</nav>

<h1>Our Products</h1>

<div class="product-container">

<?php

while($row = $products->fetch_assoc())
{
?>
<h2>

<?php
echo $products->num_rows;
?>

Products Found

</h2>
<div class="product-card">

<img
src="../uploads/products/<?php echo $row['image']; ?>">

<h3>

<?php
echo $row['product_name'];
?>

</h3>

<p>

৳ <?php echo $row['price']; ?>

</p>

<a
href="product_details.php?id=<?php echo $row['id']; ?>">

View Details

</a>

</div>

<?php
}
?>

</div>

</body>
</html>