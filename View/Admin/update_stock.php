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

Update Stock

</title>

<style>

body{
    font-family:Arial;
    padding:40px;
}

form{
    width:400px;
}

input{
    width:100%;
    padding:10px;
    margin-top:10px;
}

button{
    padding:10px 20px;
    margin-top:15px;
}

</style>

</head>

<body>

<h2>

Update Product Stock

</h2>

<form
action="../../Controller/StockController.php"
method="POST">

<input
type="hidden"
name="product_id"
value="<?php echo $row['id']; ?>">

<label>

Product Name

</label>

<input
type="text"
value="<?php echo $row['product_name']; ?>"
readonly>

<label>

Current Stock

</label>

<input
type="number"
name="stock"
value="<?php echo $row['stock']; ?>"
required>

<button
type="submit"
name="updateStock">

Update Stock

</button>

</form>

</body>

</html>