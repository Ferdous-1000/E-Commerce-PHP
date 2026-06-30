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

require_once("../../Model/CategoryModel.php");

$model =
new CategoryModel();

$conn =
$model->OpenConn();

if(!isset($_GET['id']))
{
    header("Location: manage_categories.php");
    exit();
}

$result =
$model->GetCategoryById(
    $conn,
    $_GET['id']
);

if($result->num_rows == 0)
{
    die("Category Not Found");
}

$row =
$result->fetch_assoc();

?>

<!DOCTYPE html>

<html>

<head>

<title>

Edit Category

</title>
 <link rel="stylesheet" href="../../CSS/admin-navbar.css">
<style>

body{
    font-family:Arial;
    margin:40px;
}

input{
    padding:10px;
    width:300px;
}

button{
    padding:10px 20px;
}

</style>

</head>

<body>

<?php include("layout/admin_navbar.php"); ?>
<h1>

Edit Category

</h1>

<form
action="../../Controller/CategoryController.php"
method="POST">

<input
type="hidden"
name="id"
value="<?php echo $row['id']; ?>">

<input
type="text"
name="category_name"
value="<?php echo $row['category_name']; ?>"
required>

<br><br>

<button
type="submit"
name="updateCategory">

Update Category

</button>

</form>

</body>

</html>