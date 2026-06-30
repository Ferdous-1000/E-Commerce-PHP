<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}
?>

<nav class="navbar">

<div class="logo">

<a href="index.php">

E-Commerce

</a>

</div>

<div class="links">

<a href="index.php">

Home

</a>

<a href="products.php">

Products

</a>

<a href="cart.php">

Cart

</a>

<?php

if(isset($_SESSION['id']))
{

?>

<a href="orders.php">

My Orders

</a>

<a href="profile.php">

Profile

</a>

    <a href="wishlist.php">
        Wishlist
    </a>

<a href="../Controller/LogoutController.php">

Logout

</a>

<?php

}
else
{

?>

<a href="login.php">

Login

</a>

<a href="signup.php">

Register

</a>

<?php

}

?>

</div>

</nav>