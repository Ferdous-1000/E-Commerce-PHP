<?php

session_start();

if(
    !isset($_SESSION['role'])
    ||
    $_SESSION['role'] != 'admin'
)
{
    header("Location: ../View/login.php");
    exit();
}

require_once("../Model/UserModel.php");

$user = new UserModel();

$conn = $user->OpenConn();

if(isset($_GET['block']))
{
    $user->BlockUser(
        $conn,
        $_GET['block']
    );

    header(
    "Location: ../View/Admin/manage_users.php"
    );
    exit();
}

if(isset($_GET['unblock']))
{
    $user->UnblockUser(
        $conn,
        $_GET['unblock']
    );

    header(
    "Location: ../View/Admin/manage_users.php"
    );
    exit();
}

if(isset($_GET['delete']))
{
    $userId = $_GET['delete'];

    if($userId != $_SESSION['id'])
    {
        $user->DeleteUser(
            $conn,
            $userId
        );
    }

    header(
    "Location: ../View/Admin/manage_users.php"
    );
    exit();
}

?>