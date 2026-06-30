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

<title>My Profile</title>

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

h2{
    color:#2563eb;
}

.info{
    margin:15px 0;
}

.label{
    font-weight:bold;
}

.edit-btn{
    display:inline-block;
    margin-top:20px;
    padding:10px 20px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    border-radius:5px;
}

.edit-btn:hover{
    background:#1d4ed8;
}

</style>

</head>

<body>

<?php include("layout/navbar.php"); ?>

<div class="profile-box">

<h2>My Profile</h2>

<div class="info">
<span class="label">Name:</span>
<?php echo $data['name']; ?>
</div>

<div class="info">
<span class="label">Email:</span>
<?php echo $data['email']; ?>
</div>

<div class="info">
<span class="label">Username:</span>
<?php echo $data['username']; ?>
</div>

<div class="info">
<span class="label">Role:</span>
<?php echo $data['role']; ?>
</div>

<div class="info">
<span class="label">Status:</span>
<?php echo $data['status']; ?>
</div>

<div class="info">
<span class="label">Joined:</span>
<?php echo $data['created_at']; ?>
</div>

<a
class="edit-btn"
href="edit_profile.php">

Edit Profile

</a>

<a
class="edit-btn"
href="change_password.php">

Change Password

</a>

</div>

</body>

</html>