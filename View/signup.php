<!DOCTYPE html>
<html>

<head>

<title>Signup</title>

<link rel="stylesheet"
href="../CSS/signup.css">

</head>

<body>

<div class="signup-box">

<h2>Create Account</h2>

<form
action="../Controller/SignupController.php"
method="POST"
onsubmit="return validateSignup()">

<input
type="text"
name="name"
id="name"
placeholder="Full Name">

<input
type="email"
name="email"
id="email"
placeholder="Email">

<input
type="text"
name="username"
id="username"
placeholder="Username">

<input
type="password"
name="password"
id="password"
placeholder="Password">

<button
type="submit"
name="signup">
Signup
</button>

<p>

Already have an account?

<a href="login.php">

Login

</a>

</p>

</form>

</div>

<script src="../JS/validation.js">

</script>

</body>

</html>