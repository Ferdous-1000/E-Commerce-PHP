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
    padding:40px;
}

.profile-box{
    width:500px;
    margin:auto;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
}

button{
    padding:10px 20px;
}

</style>

</head>

<body>
<?php include("layout/navbar.php"); ?>
<div class="profile-box">

<h2>My Profile</h2>

<form
action="../Controller/ProfileController.php"
method="POST">

<input
type="hidden"
name="id"
value="<?php echo $data['id']; ?>">

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

<button
type="submit"
name="updateProfile">

Update Profile

</button>

</form>

</div>

</body>
</html>