<?php

require_once("Model.php");

class CategoryModel extends Model
{
    function AddCategory($conn, $category_name)
    {
        $stmt = $conn->prepare(
            "INSERT INTO categories(category_name)
             VALUES(?)"
        );

        $stmt->bind_param(
            "s",
            $category_name
        );

        return $stmt->execute();
    }

    function GetCategories($conn)
    {
        $sql =
        "SELECT * FROM categories
         ORDER BY id DESC";

        return $conn->query($sql);
    }

    function DeleteCategory($conn, $id)
    {
        $stmt = $conn->prepare(
            "DELETE FROM categories
             WHERE id=?"
        );

        $stmt->bind_param(
            "i",
            $id
        );

        return $stmt->execute();
    }

    function GetCategoryById($conn, $id)
    {
        $stmt = $conn->prepare(
            "SELECT *
             FROM categories
             WHERE id=?"
        );

        $stmt->bind_param(
            "i",
            $id
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    function UpdateCategory(
        $conn,
        $id,
        $category_name
    )
    {
        $stmt = $conn->prepare(
            "UPDATE categories
             SET category_name=?
             WHERE id=?"
        );

        $stmt->bind_param(
            "si",
            $category_name,
            $id
        );

        return $stmt->execute();
    }

function TotalCategories($conn)
{
    $result = $conn->query(
        "SELECT COUNT(*) AS total
         FROM categories"
    );

    return $result->fetch_assoc();
}










}

?>