<?php

session_start();

if(
!isset($_SESSION['role'])
||
$_SESSION['role']!='admin'
)
{
    exit();
}

include("../Model/ProductModel.php");

$product =
new ProductModel();

$conn =
$product->OpenConn();

if(isset($_POST['addProduct']))
{
    $category_id =
    $_POST['category_id'];

    $product_name =
    $_POST['product_name'];

    $description =
    $_POST['description'];

    $price =
    $_POST['price'];

    $stock =
    $_POST['stock'];

    $imageName =
    $_FILES['image']['name'];

    $tmpName =
    $_FILES['image']['tmp_name'];

    move_uploaded_file(
        $tmpName,
        "../uploads/products/" .
        $imageName
    );

    $product->AddProduct(
        $conn,
        $category_id,
        $product_name,
        $description,
        $price,
        $stock,
        $imageName
    );

    header(
    "Location: ../View/Admin/manage_products.php"
    );
}

if(isset($_GET['delete']))
{
    $product->DeleteProduct(
        $conn,
        $_GET['delete']
    );

    header(
    "Location: ../View/Admin/manage_products.php"
    );
}

$product->CloseConn($conn);

?>