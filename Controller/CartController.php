<?php

session_start();

require_once("../Model/CartModel.php");

$cart = new CartModel();

$conn = $cart->OpenConn();

if(isset($_POST['addToCart']))
{
    $cart->AddToCart(
        $conn,
        $_SESSION['id'],
        $_POST['product_id'],
        $_POST['quantity']
    );

    header(
    "Location: ../View/cart.php"
    );
    exit();
}

if(isset($_GET['remove']))
{
    $cart->RemoveCartItem(
        $conn,
        $_GET['remove']
    );

    header(
    "Location: ../View/cart.php"
    );
    exit();
}

if(isset($_POST['updateCart']))
{
    $cart->UpdateCartQuantity(
        $conn,
        $_POST['cart_id'],
        $_POST['quantity']
    );

    header(
    "Location: ../View/cart.php"
    );
    exit();
}