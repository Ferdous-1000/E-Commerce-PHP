<?php

session_start();

require_once("../Model/CartModel.php");
require_once("../Model/OrderModel.php");
require_once("../Model/ProductModel.php");

$cart = new CartModel();
$order = new OrderModel();

$conn = $cart->OpenConn();

$user_id = $_SESSION['id'];

$cartItems =
$cart->GetCartItems(
    $conn,
    $user_id
);

$totalResult =
$cart->GetCartTotal(
    $conn,
    $user_id
);

$totalRow =
$totalResult->fetch_assoc();

$total =
$totalRow['total'];

$order_id =
$order->CreateOrder(
    $conn,
    $user_id,
    $total
);

while(
$item =
$cartItems->fetch_assoc()
)
{
    $order->AddOrderItem(
        $conn,
        $order_id,
        $item['product_id'],
        $item['quantity'],
        $item['price']
    );

    $product = new ProductModel();

$product->ReduceStock(
    $conn,
    $item['product_id'],
    $item['quantity']
);
}

$cart->ClearCart(
    $conn,
    $user_id
);

header(
"Location: ../View/orders.php"
);