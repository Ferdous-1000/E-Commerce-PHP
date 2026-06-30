
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

    <link rel="stylesheet" href="../../CSS/admin-navbar.css">
   <link rel="stylesheet" href="../../CSS/admin-dashboard.css">
    
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
