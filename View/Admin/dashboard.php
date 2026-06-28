```php
<?php

session_start();

if(
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'admin'
)
{
    header("Location: ../login.php");
    exit();
}

require_once("../../Model/CategoryModel.php");
require_once("../../Model/ProductModel.php");
require_once("../../Model/OrderModel.php");
require_once("../../Model/UserModel.php");

$categoryModel = new CategoryModel();
$productModel = new ProductModel();
$orderModel = new OrderModel();
$userModel = new UserModel();

$conn = $categoryModel->OpenConn();

$totalCategories =
$categoryModel->TotalCategories($conn);

$totalProducts =
$productModel->TotalProducts($conn);

$totalOrders =
$orderModel->TotalOrders($conn);

$totalUsers =
$userModel->TotalUsers($conn);

$lowStock =
$productModel->LowStockProducts($conn);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Dashboard</title>

    <link rel="stylesheet"
    href="../../CSS/admin-navbar.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f4f7fc;
            font-family:Arial,sans-serif;
        }

        .dashboard{
            width:95%;
            margin:25px auto;
        }

        .welcome{
            background:white;
            padding:25px;
            border-radius:10px;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
            margin-bottom:25px;
        }

        .welcome h1{
            color:#1e3a8a;
            margin-bottom:10px;
        }

        .welcome h3{
            color:#555;
        }

        .cards{
            display:grid;
            grid-template-columns:
            repeat(auto-fit,minmax(220px,1fr));
            gap:20px;
        }

        .card{
            background:white;
            border-radius:10px;
            padding:25px;
            text-align:center;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
            transition:.3s;
        }

        .card:hover{
            transform:translateY(-5px);
        }

        .card h2{
            font-size:40px;
            color:#2563eb;
            margin-bottom:10px;
        }

        .card p{
            font-size:18px;
            color:#555;
        }

        .quick-links{
            margin-top:30px;
            background:white;
            padding:25px;
            border-radius:10px;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
        }

        .quick-links h2{
            margin-bottom:20px;
            color:#1e3a8a;
        }

        .links{
            display:flex;
            gap:15px;
            flex-wrap:wrap;
        }

        .links a{
            text-decoration:none;
            background:#2563eb;
            color:white;
            padding:12px 20px;
            border-radius:5px;
        }

        .links a:hover{
            background:#1d4ed8;
        }

    </style>

</head>

<body>

<?php include("layout/admin_navbar.php"); ?>

<div class="dashboard">

    <div class="welcome">

        <h1>Admin Dashboard</h1>

        <h3>
            Welcome,
            <?php echo $_SESSION['name']; ?>
        </h3>

    </div>

    <div class="cards">

        <div class="card">
            <h2>
                <?php echo $totalCategories['total']; ?>
            </h2>
            <p>Total Categories</p>
        </div>

        <div class="card">
            <h2>
                <?php echo $totalProducts['total']; ?>
            </h2>
            <p>Total Products</p>
        </div>

        <div class="card">
            <h2>
                <?php echo $totalOrders['total']; ?>
            </h2>
            <p>Total Orders</p>
        </div>

        <div class="card">
            <h2>
                <?php echo $totalUsers['total']; ?>
            </h2>
            <p>Total Customers</p>
        </div>

        <div class="card">
            <h2>
                <?php echo $lowStock['total']; ?>
            </h2>
            <p>Low Stock Products</p>
        </div>

    </div>

    <div class="quick-links">

        <h2>Quick Actions</h2>

        <div class="links">

            <a href="manage_categories.php">
                Manage Categories
            </a>

            <a href="manage_products.php">
                Manage Products
            </a>

            <a href="manage_orders.php">
                Manage Orders
            </a>

            <a href="manage_users.php">
                Manage Users
            </a>

        </div>

    </div>

</div>

</body>

</html>
```
