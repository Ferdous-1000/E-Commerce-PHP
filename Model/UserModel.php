<?php

require_once("Model.php");

class UserModel extends Model
{

    function InsertUser(
        $conn,
        $name,
        $email,
        $username,
        $password,
        $role = "customer"
    )
    {
        $status = "active";

        $stmt = $conn->prepare(
            "INSERT INTO users
            (name,email,username,password,role,status)
            VALUES(?,?,?,?,?,?)"
        );

        $stmt->bind_param(
            "ssssss",
            $name,
            $email,
            $username,
            $password,
            $role,
            $status
        );

        return $stmt->execute();
    }

    function CheckUsername(
        $conn,
        $username
    )
    {
        $stmt = $conn->prepare(
            "SELECT *
             FROM users
             WHERE username=?"
        );

        $stmt->bind_param(
            "s",
            $username
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    function Login(
        $conn,
        $username,
        $password
    )
    {
        $stmt = $conn->prepare(
            "SELECT *
             FROM users
             WHERE username=?
             AND password=?"
        );

        $stmt->bind_param(
            "ss",
            $username,
            $password
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    function GetUserById(
        $conn,
        $id
    )
    {
        $stmt = $conn->prepare(
            "SELECT *
             FROM users
             WHERE id=?"
        );

        $stmt->bind_param(
            "i",
            $id
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    function UpdateProfile(
    $conn,
    $id,
    $name,
    $email,
    $username
)
{
    $stmt = $conn->prepare(
        "UPDATE users
         SET
         name=?,
         email=?,
         username=?
         WHERE id=?"
    );

    $stmt->bind_param(
        "sssi",
        $name,
        $email,
        $username,
        $id
    );

    return $stmt->execute();
}
    function ChangePassword(
        $conn,
        $id,
        $password
    )
    {
        $stmt = $conn->prepare(
            "UPDATE users
             SET password=?
             WHERE id=?"
        );

        $stmt->bind_param(
            "si",
            $password,
            $id
        );

        return $stmt->execute();
    }

    function TotalUsers($conn)
    {
        $result = $conn->query(
            "SELECT COUNT(*) AS total
             FROM users
             WHERE role='customer'"
        );

        return $result->fetch_assoc();
    }

    function GetAllUsers($conn)
    {
        $sql =
        "SELECT *
         FROM users
         ORDER BY id DESC";

        return $conn->query($sql);
    }

    function BlockUser(
        $conn,
        $id
    )
    {
        $stmt = $conn->prepare(
            "UPDATE users
             SET status='blocked'
             WHERE id=?"
        );

        $stmt->bind_param(
            "i",
            $id
        );

        return $stmt->execute();
    }

    function UnblockUser(
        $conn,
        $id
    )
    {
        $stmt = $conn->prepare(
            "UPDATE users
             SET status='active'
             WHERE id=?"
        );

        $stmt->bind_param(
            "i",
            $id
        );

        return $stmt->execute();
    }

    function DeleteUser(
        $conn,
        $id
    )
    {
        $stmt = $conn->prepare(
            "DELETE FROM users
             WHERE id=?"
        );

        $stmt->bind_param(
            "i",
            $id
        );

        return $stmt->execute();
    }

    function SearchUsers(
        $conn,
        $keyword
    )
    {
        $keyword = "%".$keyword."%";

        $stmt = $conn->prepare(
            "SELECT *
             FROM users
             WHERE name LIKE ?
             OR email LIKE ?
             OR username LIKE ?
             ORDER BY id DESC"
        );

        $stmt->bind_param(
            "sss",
            $keyword,
            $keyword,
            $keyword
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
         SET rating=?,
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
function GetUserPassword(
    $conn,
    $id
)
{
    $stmt = $conn->prepare(
        "SELECT password
         FROM users
         WHERE id=?"
    );

    $stmt->bind_param(
        "i",
        $id
    );

    $stmt->execute();

    return $stmt->get_result();
}
}

?>