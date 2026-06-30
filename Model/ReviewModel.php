<?php

require_once("Model.php");

class ReviewModel extends Model
{
    function AddReview(
        $conn,
        $user_id,
        $product_id,
        $rating,
        $review
    )
    {
        $stmt = $conn->prepare(
            "INSERT INTO reviews
            (
                user_id,
                product_id,
                rating,
                review
            )
            VALUES(?,?,?,?)"
        );

        $stmt->bind_param(
            "iiis",
            $user_id,
            $product_id,
            $rating,
            $review
        );

        return $stmt->execute();
    }

    function GetProductReviews(
        $conn,
        $product_id
    )
    {
        $stmt = $conn->prepare(
            "SELECT
                r.*,
                u.name
             FROM reviews r
             JOIN users u
             ON r.user_id = u.id
             WHERE r.product_id = ?
             ORDER BY r.id DESC"
        );

        $stmt->bind_param(
            "i",
            $product_id
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    function GetAverageRating(
        $conn,
        $product_id
    )
    {
        $stmt = $conn->prepare(
            "SELECT
                AVG(rating) AS avg_rating
             FROM reviews
             WHERE product_id=?"
        );

        $stmt->bind_param(
            "i",
            $product_id
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    function CheckReviewExists(
        $conn,
        $user_id,
        $product_id
    )
    {
        $stmt = $conn->prepare(
            "SELECT *
             FROM reviews
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

    function GetReviewByUserAndProduct(
        $conn,
        $user_id,
        $product_id
    )
    {
        $stmt = $conn->prepare(
            "SELECT *
             FROM reviews
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

    function UpdateReview(
        $conn,
        $review_id,
        $rating,
        $review
    )
    {
        $stmt = $conn->prepare(
            "UPDATE reviews
             SET
                rating=?,
                review=?
             WHERE id=?"
        );

        $stmt->bind_param(
            "isi",
            $rating,
            $review,
            $review_id
        );

        return $stmt->execute();
    }

    function DeleteReview(
        $conn,
        $review_id
    )
    {
        $stmt = $conn->prepare(
            "DELETE FROM reviews
             WHERE id=?"
        );

        $stmt->bind_param(
            "i",
            $review_id
        );

        return $stmt->execute();
    }
}

?>