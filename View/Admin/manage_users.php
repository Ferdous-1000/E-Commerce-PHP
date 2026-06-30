<?php

session_start();

if(
    !isset($_SESSION['role'])
    ||
    $_SESSION['role'] != 'admin'
)
{
    header("Location: ../login.php");
    exit();
}

require_once("../../Model/UserModel.php");

$user = new UserModel();

$conn = $user->OpenConn();

if(isset($_GET['search']))
{
    $users =
    $user->SearchUsers(
        $conn,
        $_GET['search']
    );
}
else
{
    $users =
    $user->GetAllUsers($conn);
}

?>

<!DOCTYPE html>
<html>

<head>

<title>

Manage Users

</title>

<link
rel="stylesheet"
href="../../CSS/admin-navbar.css">

<style>

body{
    background:#f4f7fc;
    font-family:Arial,sans-serif;
}

.container{
    width:95%;
    margin:20px auto;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.search-box input{
    padding:10px;
    width:300px;
}

.search-box button{
    padding:10px 15px;
    cursor:pointer;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

th{
    background:#2563eb;
    color:white;
    padding:12px;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

.action-btn{
    text-decoration:none;
    padding:6px 12px;
    border-radius:4px;
    color:white;
}

.block{
    background:#dc2626;
}

.unblock{
    background:#16a34a;
}

.delete{
    background:#374151;
}

.status-active{
    color:green;
    font-weight:bold;
}

.status-blocked{
    color:red;
    font-weight:bold;
}

</style>

</head>

<body>

<?php include("layout/admin_navbar.php"); ?>

<div class="container">

<div class="header">

<h2>

Manage Users

</h2>

<form
method="GET"
class="search-box">

<input
type="text"
name="search"
placeholder="Search User">

<button type="submit">

Search

</button>

</form>

</div>

<table>

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Username</th>
<th>Role</th>
<th>Status</th>
<th>Action</th>

</tr>

<?php

while(
$row =
$users->fetch_assoc()
)
{

?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['name']; ?>
</td>

<td>
<?php echo $row['email']; ?>
</td>

<td>
<?php echo $row['username']; ?>
</td>

<td>
<?php echo ucfirst($row['role']); ?>
</td>

<td>

<?php

if($row['status'] == 'active')
{
?>

<span class="status-active">

Active

</span>

<?php

}
else
{

?>

<span class="status-blocked">

Blocked

</span>

<?php

}

?>

</td>

<td>

<?php

if(
$row['role']
!=
'admin'
)
{

    if(
    $row['status']
    ==
    'active'
    )
    {

?>

<a
class="action-btn block"
href="../../Controller/UserController.php?block=<?php echo $row['id']; ?>">

Block

</a>

<?php

    }
    else
    {

?>

<a
class="action-btn unblock"
href="../../Controller/UserController.php?unblock=<?php echo $row['id']; ?>">

Unblock

</a>

<?php

    }

?>

<a
class="action-btn delete"
onclick="return confirm('Delete this user?')"
href="../../Controller/UserController.php?delete=<?php echo $row['id']; ?>">

Delete

</a>

<?php

}
else
{
    echo "Admin";
}

?>

</td>

</tr>

<?php

}

?>

</table>

</div>

</body>

</html>