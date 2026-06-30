<?php

require_once("Model.php");

class CartModel extends Model
{
    function AddToCart(
    $conn,
    $user_id,
    $product_id,
    $quantity
)
{
    $check = $conn->prepare(
        "SELECT *
         FROM cart
         WHERE user_id=?
         AND product_id=?"
    );

    $check->bind_param(
        "ii",
        $user_id,
        $product_id
    );

    $check->execute();

    $result =
    $check->get_result();

    if($result->num_rows > 0)
    {
        $update = $conn->prepare(
            "UPDATE cart
             SET quantity =
             quantity + ?
             WHERE user_id=?
             AND product_id=?"
        );

        $update->bind_param(
            "iii",
            $quantity,
            $user_id,
            $product_id
        );

        return $update->execute();
    }

    $stmt = $conn->prepare(
        "INSERT INTO cart
        (
            user_id,
            product_id,
            quantity
        )
        VALUES(?,?,?)"
    );

    $stmt->bind_param(
        "iii",
        $user_id,
        $product_id,
        $quantity
    );

    return $stmt->execute();
}

function UpdateCartQuantity(
    $conn,
    $cart_id,
    $quantity
)
{
    $stmt = $conn->prepare(
        "UPDATE cart
         SET quantity=?
         WHERE id=?"
    );

    $stmt->bind_param(
        "ii",
        $quantity,
        $cart_id
    );

    return $stmt->execute();
}
    function GetCartItems(
        $conn,
        $user_id
    )
    {
        $stmt = $conn->prepare(
            "SELECT c.*,
                    p.product_name,
                    p.price,
                    p.image

             FROM cart c

             JOIN products p
             ON c.product_id=p.id

             WHERE c.user_id=?"
        );

        $stmt->bind_param(
            "i",
            $user_id
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    function RemoveCartItem(
        $conn,
        $id
    )
    {
        $stmt = $conn->prepare(
            "DELETE FROM cart
             WHERE id=?"
        );

        $stmt->bind_param(
            "i",
            $id
        );

        return $stmt->execute();
    }



function GetCartTotal(
    $conn,
    $user_id
)
{
    $stmt = $conn->prepare(
        "SELECT
         SUM(
            p.price * c.quantity
         ) AS total

         FROM cart c

         JOIN products p
         ON c.product_id=p.id

         WHERE c.user_id=?"
    );

    $stmt->bind_param(
        "i",
        $user_id
    );

    $stmt->execute();

    return $stmt->get_result();
}

function ClearCart(
    $conn,
    $user_id
)
{
    $stmt = $conn->prepare(
        "DELETE FROM cart
         WHERE user_id=?"
    );

    $stmt->bind_param(
        "i",
        $user_id
    );

    return $stmt->execute();
}

}
?>