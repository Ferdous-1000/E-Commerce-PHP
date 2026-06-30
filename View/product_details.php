<?php

session_start();

require_once("../Model/ProductModel.php");
require_once("../Model/ReviewModel.php");

if(!isset($_GET['id']))
{
    header("Location: products.php");
    exit();
}

$product = new ProductModel();

$conn = $product->OpenConn();

$result =
$product->GetProductById(
    $conn,
    $_GET['id']
);

if($result->num_rows == 0)
{
    die("Product Not Found");
}

$row = $result->fetch_assoc();

$reviewModel = new ReviewModel();
$reviews =
$reviewModel->GetProductReviews(
    $conn,
    $_GET['id']
);

$avg =
$reviewModel->GetAverageRating(
    $conn,
    $_GET['id']
);

$avgRating =
$avg->fetch_assoc();
$userReview = null;

if(isset($_SESSION['id']))
{
    $existingReview =
    $reviewModel->GetReviewByUserAndProduct(
        $conn,
        $_SESSION['id'],
        $_GET['id']
    );

    if($existingReview->num_rows > 0)
    {
        $userReview =
        $existingReview->fetch_assoc();
    }
}

if($avgRating['avg_rating'] == NULL)
{
    $avgRating['avg_rating'] = 0;
}

?>

<!DOCTYPE html>
<html>

<head>

<title>

<?php echo $row['product_name']; ?>

</title>

<link rel="stylesheet" href="../CSS/navbar.css">
<link rel="stylesheet" href="../CSS/product_details.css">


</head>

<body>

<?php include("layout/navbar.php"); ?>

<div class="container">

<div class="product-box">

<div class="product-image">

<img
src="../uploads/products/<?php echo $row['image']; ?>">

</div>

<div class="product-info">

<h1>

<?php echo $row['product_name']; ?>

</h1>

<div class="price">

৳ <?php echo $row['price']; ?>

</div>

<div class="description">

<?php echo $row['description']; ?>

</div>

<div class="stock">

<?php

if($row['stock'] == 0)
{
    echo "<span class='out-stock'>Out Of Stock</span>";
}
elseif($row['stock'] <= 5)
{
    echo "<span class='low-stock'>Low Stock (" . $row['stock'] . " left)</span>";
}
else
{
    echo "<span class='in-stock'>In Stock (" . $row['stock'] . " available)</span>";
}

?>

</div>

<?php

if($row['stock'] > 0)
{
?>

<form method="POST"
action="../Controller/CartController.php">

<input
type="hidden"
name="product_id"
value="<?php echo $row['id']; ?>">

<label>Quantity</label>

<input
type="number"
name="quantity"
value="1"
min="1"
max="<?php echo $row['stock']; ?>"
required>

<button
type="submit"
name="addToCart">

Add To Cart

</button>

</form>
<?php
if(isset($_SESSION['id']))
{
?>

<form
method="POST"
action="../Controller/WishlistController.php">

<input
type="hidden"
name="product_id"
value="<?php echo $row['id']; ?>">

<button
type="submit"
name="addWishlist">

❤ Add To Wishlist

</button>

</form>

<?php
}
?>
<?php
}
else
{
?>

<span class="out-btn">
Unavailable
</span>

<?php
}
?>



<div class="review-form">
<?php

if(isset($_SESSION['review_success']))
{
    echo "
    <div class='success-message'>
        ".$_SESSION['review_success']."
    </div>
    ";

    unset($_SESSION['review_success']);
}



?>

<?php

if($userReview == null)
{

?>

<h2>Write A Review</h2>

<form
method="POST"
action="../Controller/ReviewController.php">

<input
type="hidden"
name="product_id"
value="<?php echo $row['id']; ?>">

<label>Rating</label>

<br><br>

<select
name="rating"
required>

<option value="5">★★★★★</option>
<option value="4">★★★★</option>
<option value="3">★★★</option>
<option value="2">★★</option>
<option value="1">★</option>

</select>

<br><br>

<textarea
name="review"
rows="5"
required></textarea>

<br><br>

<button
type="submit"
name="submitReview"
class="btn">

Submit Review

</button>

</form>

<?php

}
else
{

?>

<h2>Update Your Review</h2>

<form
method="POST"
action="../Controller/ReviewController.php">

<input
type="hidden"
name="review_id"
value="<?php echo $userReview['id']; ?>">

<input
type="hidden"
name="product_id"
value="<?php echo $row['id']; ?>">

<label>Rating</label>

<br><br>

<select
name="rating"
required>

<option
value="5"
<?php if($userReview['rating'] == 5) echo "selected"; ?>>
★★★★★
</option>

<option
value="4"
<?php if($userReview['rating'] == 4) echo "selected"; ?>>
★★★★
</option>

<option
value="3"
<?php if($userReview['rating'] == 3) echo "selected"; ?>>
★★★
</option>

<option
value="2"
<?php if($userReview['rating'] == 2) echo "selected"; ?>>
★★
</option>

<option
value="1"
<?php if($userReview['rating'] == 1) echo "selected"; ?>>
★
</option>

</select>

<br><br>

<textarea
name="review"
rows="5"
required><?php echo htmlspecialchars($userReview['review']); ?></textarea>

<br><br>

<button
type="submit"
name="updateReview"
class="btn">

Update Review

</button>

</form>

<?php

}

?>

</div>
<hr>

<h2>

Customer Reviews

</h2>

<?php

while(
$review =
$reviews->fetch_assoc()
)

{

?>

<div class="review-box">

<h4>

<?php
echo $review['name'];
?>

</h4>

<p>

<?php

for(
$i = 1;
$i <= $review['rating'];
$i++
)
{
    echo "⭐";
}

?>

</p>

<p>

<?php
echo $review['review'];
?>

</p>

<small>

<?php
echo $review['created_at'];
?>

</small>

</div>

<?php

}

?>
</div>
</body>

</html>

