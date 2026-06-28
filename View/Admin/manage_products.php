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

include("../../Model/ProductModel.php");
include("../../Model/CategoryModel.php");

$productModel =
new ProductModel();

$categoryModel =
new CategoryModel();

$conn =
$productModel->OpenConn();

$products =
$productModel->GetProducts($conn);

$categories =
$categoryModel->GetCategories($conn);

?>

<!DOCTYPE html>

<html>

<head>

<title>

Manage Products

</title>

<style>

body{
    font-family:Arial;
    margin:40px;
}

input,
textarea,
select{
    width:100%;
    padding:10px;
    margin:8px 0;
}

button{
    padding:10px 20px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:30px;
}

th,td{
    border:1px solid #ddd;
    padding:10px;
}

img{
    width:80px;
}

</style>

</head>

<body>

<h1>

Product Management

</h1>

<form
action="../../Controller/ProductController.php"
method="POST"
enctype="multipart/form-data">

<select
name="category_id"
required>

<option value="">

Select Category

</option>

<?php

while(
$cat =
$categories->fetch_assoc()
)

{

?>

<option
value="<?php echo $cat['id']; ?>">

<?php
echo $cat['category_name'];
?>

</option>

<?php

}

?>

</select>

<input
type="text"
name="product_name"
placeholder="Product Name"
required>

<textarea
name="description"
placeholder="Description">
</textarea>

<input
type="number"
step="0.01"
name="price"
placeholder="Price"
required>

<input
type="number"
name="stock"
placeholder="Stock"
required>

<input
type="file"
name="image"
required>

<button
type="submit"
name="addProduct">

Add Product

</button>

</form>

<hr>

<h2>

All Products

</h2>

<table>

<tr>

<tr>
<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Name</th>
    <th>Category</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</tr>

</tr>

<?php

while($row = $products->fetch_assoc())
{
?>

<tr>

    <td>
        <?php echo $row['id']; ?>
    </td>

    <td>
        <img
        src="../../uploads/products/<?php echo $row['image']; ?>"
        width="80">
    </td>

    <td>
        <?php echo $row['product_name']; ?>
    </td>

    <td>
        <?php echo $row['category_name']; ?>
    </td>

    <td>
        ৳ <?php echo number_format($row['price'], 2); ?>
    </td>

    <td>
        <?php echo $row['stock']; ?>
    </td>

    <td>

        <?php

        if($row['stock'] == 0)
        {
            echo "<span style='color:red;font-weight:bold;'>
                  Out Of Stock
                  </span>";
        }
        elseif($row['stock'] <= 5)
        {
            echo "<span style='color:orange;font-weight:bold;'>
                  Low Stock
                  </span>";
        }
        else
        {
            echo "<span style='color:green;font-weight:bold;'>
                  In Stock
                  </span>";
        }

        ?>

    </td>

    <td>

        <a href="edit_product.php?id=<?php echo $row['id']; ?>">
            Edit
        </a>

        |

        <a href="update_stock.php?id=<?php echo $row['id']; ?>">
            Stock
        </a>

        |

        <a
        href="../../Controller/ProductController.php?delete=<?php echo $row['id']; ?>"
        onclick="return confirm('Are you sure you want to delete this product?');">
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