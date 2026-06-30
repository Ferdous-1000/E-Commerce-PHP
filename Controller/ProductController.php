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

include("../Model/ProductModel.php");

$product = new ProductModel();
$conn = $product->OpenConn();

/* ADD PRODUCT */

if(isset($_POST['addProduct']))
{
    $category_id = $_POST['category_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $imageName = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];

    move_uploaded_file(
        $tmpName,
        "../uploads/products/" . $imageName
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
    exit();
}

/* DELETE PRODUCT */

if(isset($_GET['delete']))
{
    $productData =
    $product->GetProductById(
        $conn,
        $_GET['delete']
    );

    if($productData->num_rows > 0)
    {
        $row =
        $productData->fetch_assoc();

        $imagePath =
        "../uploads/products/" .
        $row['image'];

        if(file_exists($imagePath))
        {
            unlink($imagePath);
        }
    }

    $product->DeleteProduct(
        $conn,
        $_GET['delete']
    );

    header(
    "Location: ../View/Admin/manage_products.php"
    );

    exit();
}
/* UPDATE PRODUCT */

if(isset($_POST['updateProduct']))
{
    $id = $_POST['product_id'];
    $category_id = $_POST['category_id'];
    $name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $image = $_POST['old_image'];

    if(!empty($_FILES['image']['name']))
{
    $oldImagePath =
    "../uploads/products/" .
    $image;

    if(file_exists($oldImagePath))
    {
        unlink($oldImagePath);
    }

    $image =
    time() . "_" .
    $_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../uploads/products/" . $image
    );
}
    $result =
    $product->UpdateProduct(
        $conn,
        $id,
        $category_id,
        $name,
        $description,
        $price,
        $stock,
        $image
    );

    if($result)
    {
        header(
            "Location: ../View/Admin/manage_products.php"
        );
        exit();
    }
    else
    {
        echo "Product Update Failed";
    }
}

$product->CloseConn($conn);

?>