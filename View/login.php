<!DOCTYPE html>
<html>

<head>

<title>Login</title>

<link rel="stylesheet"
href="../CSS/login.css">

</head>

<body>

<div class="login-box">

<h2>Login</h2>

<form
action="../Controller/LoginController.php"
method="POST">

<input
type="text"
name="username"
placeholder="Username"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button
type="submit"
name="login">

Login

</button>

<p>

Don't have an account?

<a href="signup.php">

Signup

</a>

</p>

</form>

</div>

</body>

</html>