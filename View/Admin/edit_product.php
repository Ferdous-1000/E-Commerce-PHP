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

require_once("../../Model/ProductModel.php");
require_once("../../Model/CategoryModel.php");

$productModel = new ProductModel();
$categoryModel = new CategoryModel();

$conn = $productModel->OpenConn();

if(!isset($_GET['id']))
{
    header("Location: manage_products.php");
    exit();
}

$productId = $_GET['id'];

$productResult =
$productModel->GetProductById(
    $conn,
    $productId
);

if($productResult->num_rows == 0)
{
    die("Product Not Found");
}

$product =
$productResult->fetch_assoc();

$categories =
$categoryModel->GetCategories($conn);

?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Product</title>

<style>

body{
    font-family:Arial,sans-serif;
    background:#f4f7fc;
    margin:0;
}

.container{
    width:700px;
    margin:30px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

h1{
    text-align:center;
    color:#1e3a8a;
}

input,
textarea,
select{
    width:100%;
    padding:10px;
    margin-top:8px;
    margin-bottom:15px;
}

button{
    background:#2563eb;
    color:white;
    border:none;
    padding:12px 20px;
    cursor:pointer;
    border-radius:5px;
}

button:hover{
    background:#1d4ed8;
}

img{
    width:120px;
    border-radius:8px;
    margin-bottom:10px;
}

</style>

</head>

<body>

<div class="container">

<h1>Edit Product</h1>

<form
action="../../Controller/ProductController.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="product_id"
value="<?php echo $product['id']; ?>">
<input
type="hidden"
name="old_image"
value="<?php echo $product['image']; ?>">
<label>Product Name</label>

<input
type="text"
name="product_name"
value="<?php echo $product['product_name']; ?>"
required>

<label>Price</label>

<input
type="number"
step="0.01"
name="price"
value="<?php echo $product['price']; ?>"
required>

<label>Description</label>

<textarea
name="description"
rows="5"
required><?php echo $product['description']; ?></textarea>

<label>Stock</label>

<input
type="number"
name="stock"
value="<?php echo $product['stock']; ?>"
required>

<label>Category</label>

<select
name="category_id"
required>

<?php

while(
$cat =
$categories->fetch_assoc()
)
{

?>

<option
value="<?php echo $cat['id']; ?>"
<?php
if(
$product['category_id']
==
$cat['id']
)
{
    echo "selected";
}
?>>

<?php echo $cat['category_name']; ?>

</option>

<?php

}

?>

</select>

<label>Current Image</label>

<br>

<img
src="../../uploads/products/<?php echo $product['image']; ?>">

<br><br>

<label>New Image (Optional)</label>

<input
type="file"
name="image">

<button
type="submit"
name="updateProduct">

Update Product

</button>

</form>

</div>

</body>

</html>

<?php

$productModel->CloseConn($conn);

?>