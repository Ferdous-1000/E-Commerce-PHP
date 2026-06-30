<?php

session_start();

if(!isset($_SESSION['id']))
{
    header("Location: login.php");
    exit();
}

require_once("../Model/UserModel.php");

$user = new UserModel();

$conn = $user->OpenConn();

$result =
$user->GetUserById(
    $conn,
    $_SESSION['id']
);

$data =
$result->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Profile</title>

<link rel="stylesheet" href="../CSS/navbar.css">

<style>

body{
    font-family:Arial;
    background:#f4f7fc;
    margin:0;
}

.profile-box{
    width:600px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

input{
    width:100%;
    padding:10px;
    margin-top:5px;
    margin-bottom:15px;
}

button{
    background:#2563eb;
    color:white;
    border:none;
    padding:10px 20px;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#1d4ed8;
}

</style>

</head>

<body>

<?php include("layout/navbar.php"); ?>

<div class="profile-box">

<h2>Edit Profile</h2>

<form
action="../Controller/ProfileController.php"
method="POST">

<label>Name</label>

<input
type="text"
name="name"
value="<?php echo $data['name']; ?>"
required>

<label>Email</label>

<input
type="email"
name="email"
value="<?php echo $data['email']; ?>"
required>

<label>Username</label>

<input
type="text"
name="username"
value="<?php echo $data['username']; ?>"
required>

<button
type="submit"
name="updateProfile">

Update Profile

</button>

</form>

<hr>

<h3>Change Password</h3>

<form
action="../Controller/ProfileController.php"
method="POST">

<input
type="password"
name="password"
placeholder="New Password"
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