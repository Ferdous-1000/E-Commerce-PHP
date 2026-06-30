```php
<?php

session_start();

require_once("../Model/ProductModel.php");
require_once("../Model/CategoryModel.php");

$productModel = new ProductModel();
$categoryModel = new CategoryModel();

$conn = $productModel->OpenConn();

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

<link rel="stylesheet" href="../CSS/navbar.css">

<style>

body{
    margin:0;
    background:#f4f7fc;
    font-family:Arial,sans-serif;
}

.search-box{
    width:95%;
    margin:20px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.search-box form{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.search-box input,
.search-box select{
    padding:10px;
    min-width:180px;
}

.search-box button{
    padding:10px 20px;
    background:#2563eb;
    color:white;
    border:none;
    cursor:pointer;
}

.title{
    text-align:center;
    color:#1e3a8a;
}

.result-count{
    text-align:center;
    margin-bottom:20px;
}

.product-container{
    width:95%;
    margin:auto;

    display:grid;
    grid-template-columns:
    repeat(auto-fill,minmax(250px,1fr));

    gap:20px;

    margin-bottom:40px;
}

.product-card{
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
    transition:.3s;
}

.product-card:hover{
    transform:translateY(-5px);
}

.product-card img{
    width:100%;
    height:220px;
    object-fit:cover;
}

.content{
    padding:15px;
}

.content h3{
    margin-bottom:10px;
}

.category{
    color:#666;
    margin-bottom:10px;
}

.price{
    font-size:22px;
    color:#2563eb;
    font-weight:bold;
    margin-bottom:10px;
}

.stock{
    margin-bottom:10px;
}

.in-stock{
    color:green;
    font-weight:bold;
}

.low-stock{
    color:orange;
    font-weight:bold;
}

.out-stock{
    color:red;
    font-weight:bold;
}

.button-group{
    display:flex;
    gap:10px;
    margin-top:15px;
}

.btn{
    flex:1;
    display:flex;
    justify-content:center;
    align-items:center;

    padding:12px;
    border:none;
    border-radius:6px;

    color:white;
    text-decoration:none;

    font-size:14px;
    font-weight:bold;

    cursor:pointer;
    transition:.3s;
}

.view-btn{
    background:#2563eb;
}

.view-btn:hover{
    background:#1d4ed8;
}

.cart-btn{
    background:#16a34a;
}

.cart-btn:hover{
    background:#15803d;
}

.disabled-btn{
    width:100%;
    display:block;

    text-align:center;

    padding:12px;

    background:#9ca3af;

    color:white;

    border-radius:6px;

    margin-top:15px;
}

.product-card{
    background:white;
    border-radius:10px;
    overflow:hidden;

    box-shadow:0 2px 10px rgba(0,0,0,.1);

    transition:.3s;

    display:flex;
    flex-direction:column;
}

.content{
    padding:15px;

    display:flex;
    flex-direction:column;

    flex-grow:1;
}
</style>

</head>

<body>

<?php include("layout/navbar.php"); ?>

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
while($cat = $categories->fetch_assoc())
{
?>

<option
value="<?php echo $cat['id']; ?>"
<?php
if($category_id == $cat['id'])
{
    echo "selected";
}
?>
>

<?php echo $cat['category_name']; ?>

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

<h1 class="title">

Our Products

</h1>

<p class="result-count">

<?php echo $products->num_rows; ?>

Products Found

</p>

<div class="product-container">

<?php

while($row = $products->fetch_assoc())
{

?>

<div class="product-card">

<img
src="../uploads/products/<?php echo $row['image']; ?>">

<div class="content">

<h3>

<?php echo $row['product_name']; ?>

</h3>

<div class="category">

Category:
<?php echo $row['category_name']; ?>

</div>

<div class="price">

৳ <?php echo $row['price']; ?>

</div>

<div class="stock">

<?php

if($row['stock'] == 0)
{
    echo "<span class='out-stock'>Out Of Stock</span>";
}
elseif($row['stock'] <= 5)
{
    echo "<span class='low-stock'>Low Stock</span>";
}
else
{
    echo "<span class='in-stock'>In Stock</span>";
}

?>

</div>

<div class="button-group">

<a
class="btn view-btn"
href="product_details.php?id=<?php echo $row['id']; ?>">

View Details

</a>

<?php

if($row['stock'] > 0)
{

?>

<form
method="POST"
action="../Controller/CartController.php"
style="flex:1; margin:0;">

<input
type="hidden"
name="product_id"
value="<?php echo $row['id']; ?>">

<input
type="hidden"
name="quantity"
value="1">

<button
type="submit"
name="addToCart"
class="btn cart-btn">

Add To Cart

</button>
<form
method="POST"
action="../Controller/WishlistController.php">

<input
type="hidden"
name="product_id"
value="<?php echo $row['id']; ?>">


</form>

<?php

}
else
{

?>

<span class="disabled-btn">

Unavailable

</span>

<?php

}

?>

</div>


</div>

</div>

<?php

}

?>

</div>

</body>

</html>
```
