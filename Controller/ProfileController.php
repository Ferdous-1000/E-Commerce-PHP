<?php

session_start();

require_once("../Model/UserModel.php");

$user = new UserModel();

$conn = $user->OpenConn();

if(isset($_POST['updateProfile']))
{
    $user->UpdateProfile(
        $conn,
        $_POST['id'],
        $_POST['name'],
        $_POST['email']
    );

    header(
    "Location: ../View/profile.php"
    );
}