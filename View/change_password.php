<?php

session_start();

if(!isset($_SESSION['id']))
{
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>

<html>

<head>

<title>Change Password</title>

<link rel="stylesheet" href="../CSS/navbar.css">

<style>

body{
    background:#f4f7fc;
    font-family:Arial,sans-serif;
    margin:0;
}

.container{
    width:500px;
    margin:50px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

h2{
    text-align:center;
    color:#1e3a8a;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
    box-sizing:border-box;
}

button{
    background:#2563eb;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#1d4ed8;
}

.error{
    color:red;
    margin-bottom:15px;
}

.success{
    color:green;
    margin-bottom:15px;
}

</style>

</head>

<body>

<?php include("layout/navbar.php"); ?>

<div class="container">

<h2>Change Password</h2>

<?php

if(isset($_SESSION['password_error']))
{
    echo "<p class='error'>".$_SESSION['password_error']."</p>";
    unset($_SESSION['password_error']);
}

if(isset($_SESSION['password_success']))
{
    echo "<p class='success'>".$_SESSION['password_success']."</p>";
    unset($_SESSION['password_success']);
}

?>

<form
action="../Controller/ProfileController.php"
method="POST">

<label>Current Password</label>

<input
type="password"
name="current_password"
required>

<label>New Password</label>

<input
type="password"
name="new_password"
required>

<label>Confirm New Password</label>

<input
type="password"
name="confirm_password"
required>

<button
type="submit"
name="changePassword">

Change Password

</button>

</form>

</div>

</body>

</html>
?>
