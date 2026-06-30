<?php

session_start();

if(!isset($_SESSION['id']))
{
    header("Location: ../View/login.php");
    exit();
}

require_once("../Model/WishlistModel.php");

$wishlist = new WishlistModel();

$conn = $wishlist->OpenConn();

if(isset($_POST['addWishlist']))
{
    $user_id = $_SESSION['id'];
    $product_id = $_POST['product_id'];

    $check =
    $wishlist->CheckWishlist(
        $conn,
        $user_id,
        $product_id
    );

    if($check->num_rows == 0)
    {
        $wishlist->AddWishlist(
            $conn,
            $user_id,
            $product_id
        );
    }

    header(
    "Location: ../View/product_details.php?id=".$product_id
    );
    exit();
}

if(isset($_GET['remove']))
{
    $wishlist->RemoveWishlist(
        $conn,
        $_GET['remove']
    );

    header(
    "Location: ../View/wishlist.php"
    );

    exit();
}

$wishlist->CloseConn($conn);

?>