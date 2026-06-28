<?php

session_start();

if(
!isset($_SESSION['role'])
||
$_SESSION['role'] != 'admin'
)
{
    exit();
}

require_once("../Model/ProductModel.php");

$product = new ProductModel();

$conn = $product->OpenConn();

if(isset($_POST['updateStock']))
{
    $product_id =
    $_POST['product_id'];

    $stock =
    $_POST['stock'];

    if($stock < 0)
    {
        die("Stock cannot be negative");
    }

    $product->UpdateStock(
        $conn,
        $product_id,
        $stock
    );

    header(
    "Location: ../View/Admin/manage_products.php"
    );
}