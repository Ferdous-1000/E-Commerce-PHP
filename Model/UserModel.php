<?php

require_once("Model.php");

class UserModel extends Model
{
    function InsertUser(
        $conn,
        $name,
        $email,
        $username,
        $password
    )
    {
        $stmt = $conn->prepare(
            "INSERT INTO users
            (name,email,username,password)
            VALUES(?,?,?,?)"
        );

        $stmt->bind_param(
            "ssss",
            $name,
            $email,
            $username,
            $password
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

function GetUserById($conn, $id)
{
    $stmt = $conn->prepare(
        "SELECT *
         FROM users
         WHERE id=?"
    );

    $stmt->bind_param("i", $id);

    $stmt->execute();

    return $stmt->get_result();
}

function UpdateProfile(
    $conn,
    $id,
    $name,
    $email
)
{
    $stmt = $conn->prepare(
        "UPDATE users
         SET name=?,
             email=?
         WHERE id=?"
    );

    $stmt->bind_param(
        "ssi",
        $name,
        $email,
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








}

?>