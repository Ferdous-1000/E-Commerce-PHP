<?php

session_start();

require_once("../Model/ReviewModel.php");

if(!isset($_SESSION['id']))
{
    exit();
}

$reviewModel = new ReviewModel();

$conn = $reviewModel->OpenConn();

/* ADD REVIEW */

if(isset($_POST['submitReview']))
{
    $check =
    $reviewModel->CheckReviewExists(
        $conn,
        $_SESSION['id'],
        $_POST['product_id']
    );

    if($check->num_rows > 0)
    {
        $_SESSION['review_error'] =
        "You have already reviewed this product.";

        header(
        "Location: ../View/product_details.php?id="
        .
        $_POST['product_id']
        );

        exit();
    }

    $reviewModel->AddReview(
        $conn,
        $_SESSION['id'],
        $_POST['product_id'],
        $_POST['rating'],
        $_POST['review']
    );

    $_SESSION['review_success'] =
    "Review submitted successfully.";

    header(
    "Location: ../View/product_details.php?id="
    .
    $_POST['product_id']
    );

    exit();
}

/* UPDATE REVIEW */

if(isset($_POST['updateReview']))
{
    $reviewModel->UpdateReview(
        $conn,
        $_POST['review_id'],
        $_POST['rating'],
        $_POST['review']
    );

    $_SESSION['review_success'] =
    "Review updated successfully.";

    header(
    "Location: ../View/product_details.php?id="
    .
    $_POST['product_id']
    );

    exit();
}

$reviewModel->CloseConn($conn);

?>