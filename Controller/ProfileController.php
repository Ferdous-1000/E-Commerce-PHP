<?php

session_start();

if(!isset($_SESSION['id']))
{
    header("Location: ../View/login.php");
    exit();
}

require_once("../Model/UserModel.php");

$user = new UserModel();

$conn = $user->OpenConn();

/* UPDATE PROFILE */

if(isset($_POST['updateProfile']))
{
    $user->UpdateProfile(
        $conn,
        $_SESSION['id'],
        $_POST['name'],
        $_POST['email'],
        $_POST['username']
    );

    header(
    "Location: ../View/profile.php"
    );

    exit();
}

/* CHANGE PASSWORD */

if(isset($_POST['changePassword']))
{
$result =
$user->GetUserPassword(
$conn,
$_SESSION['id']
);

$row =
$result->fetch_assoc();

if(
    $_POST['current_password']
    !=
    $row['password']
)
{
    $_SESSION['password_error'] =
    "Current password is incorrect.";

    header(
    "Location: ../View/change_password.php"
    );

    exit();
}

if(
    $_POST['new_password']
    !=
    $_POST['confirm_password']
)
{
    $_SESSION['password_error'] =
    "Passwords do not match.";

    header(
    "Location: ../View/change_password.php"
    );

    exit();
}

$user->ChangePassword(
    $conn,
    $_SESSION['id'],
    $_POST['new_password']
);

$_SESSION['password_success'] =
"Password changed successfully.";

header(
"Location: ../View/change_password.php"
);

exit();

}

$user->CloseConn($conn);

?>