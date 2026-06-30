<?php

require_once("Model.php");

class WishlistModel extends Model
{
    function AddWishlist(
        $conn,
        $user_id,
        $product_id
    )
    {
        $stmt = $conn->prepare(
            "INSERT INTO wishlist
            (user_id,product_id)
            VALUES(?,?)"
        );

        $stmt->bind_param(
            "ii",
            $user_id,
            $product_id
        );

        return $stmt->execute();
    }

    function CheckWishlist(
        $conn,
        $user_id,
        $product_id
    )
    {
        $stmt = $conn->prepare(
            "SELECT *
             FROM wishlist
             WHERE user_id=?
             AND product_id=?"
        );

        $stmt->bind_param(
            "ii",
            $user_id,
            $product_id
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    function GetWishlist(
        $conn,
        $user_id
    )
    {
        $stmt = $conn->prepare(
            "SELECT
                w.*,
                p.product_name,
                p.price,
                p.image,
                p.stock
             FROM wishlist w
             JOIN products p
             ON w.product_id=p.id
             WHERE w.user_id=?"
        );

        $stmt->bind_param(
            "i",
            $user_id
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    function RemoveWishlist(
        $conn,
        $id
    )
    {
        $stmt = $conn->prepare(
            "DELETE FROM wishlist
             WHERE id=?"
        );

        $stmt->bind_param(
            "i",
            $id
        );

        return $stmt->execute();
    }
}
?>