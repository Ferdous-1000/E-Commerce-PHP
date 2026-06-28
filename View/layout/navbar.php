<?php
session_start();
?>

<nav>

    <a href="index.php">Home</a>

    <a href="products.php">Products</a>

    <a href="cart.php">Cart</a>

    <?php
    if(isset($_SESSION['id']))
    {
    ?>
        <a href="profile.php">My Account</a>

        <a href="orders.php">My Orders</a>

        <a href="../Controller/LogoutController.php">
            Logout
        </a>
    <?php
    }
    else
    {
    ?>
        <a href="login.php">Login</a>

        <a href="signup.php">Register</a>
    <?php
    }
    ?>

</nav>