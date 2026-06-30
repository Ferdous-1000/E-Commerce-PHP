<?php

require_once("Model.php");

class OrderModel extends Model
{
    function CreateOrder(
        $conn,
        $user_id,
        $total
    )
    {
        $stmt = $conn->prepare(
            "INSERT INTO orders
            (user_id,total_amount)
            VALUES(?,?)"
        );

        $stmt->bind_param(
            "id",
            $user_id,
            $total
        );

        $stmt->execute();

        return $conn->insert_id;
    }

    function AddOrderItem(
        $conn,
        $order_id,
        $product_id,
        $quantity,
        $price
    )
    {
        $stmt = $conn->prepare(
            "INSERT INTO order_items
            (
                order_id,
                product_id,
                quantity,
                price
            )
            VALUES(?,?,?,?)"
        );

        $stmt->bind_param(
            "iiid",
            $order_id,
            $product_id,
            $quantity,
            $price
        );

        return $stmt->execute();
    }

    
function GetAllOrders($conn)
{
    $sql = "
        SELECT
            o.*,
            u.name,
            u.email

        FROM orders o

        JOIN users u
        ON o.user_id = u.id

        ORDER BY o.id DESC
    ";

    return $conn->query($sql);
}
function UpdateOrderStatus(
    $conn,
    $order_id,
    $status
)
{
    $stmt = $conn->prepare(
        "UPDATE orders
         SET status=?
         WHERE id=?"
    );

    $stmt->bind_param(
        "si",
        $status,
        $order_id
    );

    return $stmt->execute();
}
function GetOrderItems(
    $conn,
    $order_id
)
{
    $stmt = $conn->prepare(
        "SELECT
            oi.*,
            p.product_name,
            p.image

         FROM order_items oi

         JOIN products p
         ON oi.product_id=p.id

         WHERE oi.order_id=?"
    );

    $stmt->bind_param(
        "i",
        $order_id
    );

    $stmt->execute();

    return $stmt->get_result();
}
function TotalOrders($conn)
{
    $result = $conn->query(
        "SELECT COUNT(*) AS total
         FROM orders"
    );

    return $result->fetch_assoc();
}
function GetOrdersByUser(
    $conn,
    $user_id
)
{
    $stmt = $conn->prepare(
        "SELECT *
         FROM orders
         WHERE user_id=?
         ORDER BY id DESC"
    );

    $stmt->bind_param(
        "i",
        $user_id
    );

    $stmt->execute();

    return $stmt->get_result();
}

function GetOrderById(
    $conn,
    $order_id
)
{
    $stmt = $conn->prepare(
        "SELECT *
         FROM orders
         WHERE id=?"
    );

    $stmt->bind_param(
        "i",
        $order_id
    );

    $stmt->execute();

    return $stmt->get_result();
}









}
?>