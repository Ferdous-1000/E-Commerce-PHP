<?php

session_start();

require_once("../Model/CartModel.php");

$cart = new CartModel();

$conn = $cart->OpenConn();

if(isset($_GET['add']))
{
    $cart->AddToCart(
        $conn,
        $_SESSION['id'],
        $_GET['add']
    );

    header(
    "Location: ../View/cart.php"
    );
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
}