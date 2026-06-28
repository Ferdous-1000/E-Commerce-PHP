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

require_once("../Model/OrderModel.php");

$order = new OrderModel();

$conn = $order->OpenConn();

if(isset($_POST['updateStatus']))
{
 $result = $order->UpdateOrderStatus(
    $conn,
    $_POST['order_id'],
    $_POST['status']
);

if($result)
{
    header("Location: ../View/Admin/manage_orders.php");
    exit();
}
else
{
    echo "Update Failed";
}
}