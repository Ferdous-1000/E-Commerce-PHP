```php
<?php

session_start();

include("../Model/UserModel.php");

if(isset($_POST['login']))
{
    $username =
    $_POST['username'];

    $password =
    $_POST['password'];

    $user =
    new UserModel();

    $conn =
    $user->OpenConn();

    $result =
    $user->Login(
        $conn,
        $username,
        $password
    );

    if($result->num_rows > 0)
    {
        $row =
        $result->fetch_assoc();

        if(
            isset($row['status'])
            &&
            $row['status'] == 'blocked'
        )
        {
            die(
            "Your account has been blocked by admin."
            );
        }

        $_SESSION['id'] =
        $row['id'];

        $_SESSION['name'] =
        $row['name'];

        $_SESSION['role'] =
        $row['role'];

        if(
            $row['role']
            == 'admin'
        )
        {
            header(
            "Location: ../View/Admin/dashboard.php"
            );
            exit();
        }
        else
        {
            header(
            "Location: ../View/index.php"
            );
            exit();
        }
    }
    else
    {
        echo
        "Invalid Username or Password";
    }

    $user->CloseConn($conn);
}

?>
```
