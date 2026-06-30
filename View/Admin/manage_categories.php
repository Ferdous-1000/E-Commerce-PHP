<?php

session_start();

if(
!isset($_SESSION['role'])
||
$_SESSION['role']!='admin'
)
{
    header("Location: ../login.php");
    exit();
}

include("../../Model/CategoryModel.php");

$model =
new CategoryModel();

$conn =
$model->OpenConn();

$categories =
$model->GetCategories($conn);

?>

<!DOCTYPE html>

<html>

<head>

<title>

Manage Categories

</title>
 <link rel="stylesheet" href="../../CSS/admin-navbar.css">
<style>

body{
    font-family:Arial;
    margin:40px;
}

form{
    margin-bottom:20px;
}

input{
    padding:10px;
}

button{
    padding:10px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    border:1px solid #ddd;
    padding:12px;
}

</style>

</head>

<body>

<?php include("layout/admin_navbar.php"); ?>
<h1>

Category Management

</h1>

<form
action="../../Controller/CategoryController.php"
method="POST">

<input
type="text"
name="category_name"
placeholder="Category Name"
required>

<button
type="submit"
name="addCategory">

Add Category

</button>

</form>

<table>

<tr>

<th>ID</th>
<th>Name</th>
<th>Action</th>

</tr>

<?php

while(
$row =
$categories->fetch_assoc()
)

{

?>

<tr>

<td>

<?php
echo $row['id'];
?>

</td>

<td>

<?php
echo $row['category_name'];
?>

</td>

<td>

<a
href="edit_category.php?id=<?php echo $row['id']; ?>">

Edit

</a>

|

<a
href="../../Controller/CategoryController.php?delete=<?php echo $row['id']; ?>">

Delete

</a>

</td>

</tr>

<?php

}

?>

</table>

</body>

</html>

<?php

$model->CloseConn($conn);

?>