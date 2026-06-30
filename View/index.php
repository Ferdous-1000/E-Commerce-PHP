<?php

session_start();

require_once("../Model/ProductModel.php");

$product = new ProductModel();

$conn = $product->OpenConn();

$products =
$product->GetAllProducts($conn);

?>

<!DOCTYPE html>
<html>

<head>

<title>

E-Commerce Store

</title>

<link
rel="stylesheet"
href="../CSS/navbar.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#f4f7fc;
}

.hero{
    background:linear-gradient(
    rgba(0,0,0,.5),
    rgba(0,0,0,.5)
    ),
    url("../uploads/banner.jpg");

    background-size:cover;
    background-position:center;

    height:400px;

    display:flex;
    justify-content:center;
    align-items:center;
    flex-direction:column;

    color:white;
    text-align:center;
}

.hero h1{
    font-size:50px;
    margin-bottom:15px;
}

.hero p{
    font-size:20px;
}

.hero a{
    margin-top:20px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    padding:12px 25px;
    border-radius:5px;
}

.hero a:hover{
    background:#1d4ed8;
}

.section-title{
    text-align:center;
    margin:40px 0 20px;
    color:#1e3a8a;
}

.products{
    width:95%;
    margin:auto;

    display:grid;
    grid-template-columns:
    repeat(auto-fill,minmax(250px,1fr));

    gap:20px;

    margin-bottom:50px;
}

.card{
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
    transition:.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card img{
    width:100%;
    height:220px;
    object-fit:cover;
}

.card-content{
    padding:15px;
}

.card h3{
    margin-bottom:10px;
}

.price{
    color:#2563eb;
    font-size:20px;
    font-weight:bold;
    margin-bottom:10px;
}

.btn{
    display:inline-block;
    padding:10px 15px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    border-radius:5px;
}

.btn:hover{
    background:#1d4ed8;
}

.footer{
    background:#1e293b;
    color:white;
    text-align:center;
    padding:20px;
}

</style>

</head>

<body>

<?php include("layout/navbar.php"); ?>

<div class="hero">

<h1>

Welcome To Our Store

</h1>

<p>

Best Products At Best Prices

</p>

<a href="products.php">

Shop Now

</a>

</div>

<h2 class="section-title">

Featured Products

</h2>

<div class="products">

<?php

$count = 0;

while(
$row =
$products->fetch_assoc()
)
{

if($count == 8)
{
    break;
}

?>

<div class="card">

<img
src="../uploads/products/<?php echo $row['image']; ?>">

<div class="card-content">

<h3>

<?php echo $row['product_name']; ?>

</h3>

<div class="price">

৳ <?php echo $row['price']; ?>

</div>

<a
class="btn"
href="product_details.php?id=<?php echo $row['id']; ?>">

View Product

</a>

</div>

</div>

<?php

$count++;

}

?>

</div>

<div class="footer">

<p>

© 2026 E-Commerce Store.
All Rights Reserved.

</p>

</div>

</body>

</html>