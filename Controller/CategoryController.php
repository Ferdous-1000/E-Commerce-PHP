<?php

session_start();

if(
!isset($_SESSION['role'])
||
$_SESSION['role'] != 'admin'
)
{
    exit();
}

include("../Model/CategoryModel.php");

$model =
new CategoryModel();

$conn =
$model->OpenConn();

if(isset($_POST['addCategory']))
{
    $category_name =
    trim($_POST['category_name']);

    $model->AddCategory(
        $conn,
        $category_name
    );

    header(
    "Location: ../View/Admin/manage_categories.php"
    );
}

if(isset($_GET['delete']))
{
    $model->DeleteCategory(
        $conn,
        $_GET['delete']
    );

    header(
    "Location: ../View/Admin/manage_categories.php"
    );
}

$model->CloseConn($conn);

?>