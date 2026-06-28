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

<title>Home</title>

</head>

<body>

<h1>

Welcome

<?php
echo $_SESSION['name'];
?>

</h1>

<p>

Customer Home Page

</p>

<a href="../Controller/LogoutController.php">

Logout

</a>

</body>

</html>