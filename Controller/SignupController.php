<?php

include("../Model/UserModel.php");

if(isset($_POST['signup']))
{
    $name =
    $_POST['name'];

    $email =
    $_POST['email'];

    $username =
    $_POST['username'];

    $password =
    $_POST['password'];

    $user =
    new UserModel();

    $conn =
    $user->OpenConn();

    $check =
    $user->CheckUsername(
        $conn,
        $username
    );

    if($check->num_rows > 0)
    {
        echo
        "Username already exists";
    }
    else
    {
        if(
            $user->InsertUser(
                $conn,
                $name,
                $email,
                $username,
                $password
            )
        )
        {
            header(
                "Location: ../View/login.php"
            );
        }
        else
        {
            echo
            "Registration Failed";
        }
    }

    $user->CloseConn(
        $conn
    );
}

?>