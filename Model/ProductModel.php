<?php

require_once("Model.php");

class ProductModel extends Model
{
    function AddProduct(
        $conn,
        $category_id,
        $product_name,
        $description,
        $price,
        $stock,
        $image
    )
    {
        $stmt = $conn->prepare(
            "INSERT INTO products
            (
                category_id,
                product_name,
                description,
                price,
                stock,
                image
            )
            VALUES(?,?,?,?,?,?)"
        );

        $stmt->bind_param(
            "issdis",
            $category_id,
            $product_name,
            $description,
            $price,
            $stock,
            $image
        );

        return $stmt->execute();
    }

    function GetProducts($conn)
    {
        $sql =
        "SELECT p.*,
        c.category_name

        FROM products p

        LEFT JOIN categories c
        ON p.category_id=c.id

        ORDER BY p.id DESC";

        return $conn->query($sql);
    }

    function DeleteProduct(
        $conn,
        $id
    )
    {
        $stmt =
        $conn->prepare(
        "DELETE FROM products
        WHERE id=?"
        );

        $stmt->bind_param(
        "i",
        $id
        );

        return $stmt->execute();
    }


function GetAllProducts($conn)
{
    $sql = "
        SELECT p.*, c.category_name
        FROM products p
        LEFT JOIN categories c
        ON p.category_id = c.id
        ORDER BY p.id DESC
    ";

    return $conn->query($sql);
}
function GetProductById($conn,$id)
{
    $stmt = $conn->prepare(
        "SELECT *
         FROM products
         WHERE id=?"
    );

    $stmt->bind_param("i",$id);

    $stmt->execute();

    return $stmt->get_result();
}


function UpdateStock(
    $conn,
    $product_id,
    $stock
)
{
    $stmt = $conn->prepare(
        "UPDATE products
         SET stock=?
         WHERE id=?"
    );

    $stmt->bind_param(
        "ii",
        $stock,
        $product_id
    );

    return $stmt->execute();
}
function SearchProducts(
    $conn,
    $keyword = '',
    $category_id = '',
    $sort = ''
)
{
    $sql = "
        SELECT p.*, c.category_name
        FROM products p
        LEFT JOIN categories c
        ON p.category_id = c.id
        WHERE 1=1
    ";

    if(!empty($keyword))
    {
        $keyword = $conn->real_escape_string($keyword);

        $sql .= "
        AND p.product_name
        LIKE '%$keyword%'";
    }

    if(!empty($category_id))
    {
        $category_id = (int)$category_id;

        $sql .= "
        AND p.category_id=$category_id";
    }

    switch($sort)
    {
        case 'price_low':
            $sql .= " ORDER BY p.price ASC";
            break;

        case 'price_high':
            $sql .= " ORDER BY p.price DESC";
            break;

        default:
            $sql .= " ORDER BY p.id DESC";
    }

    return $conn->query($sql);
}

function TotalProducts($conn)
{
    $result = $conn->query(
        "SELECT COUNT(*) AS total
         FROM products"
    );

    return $result->fetch_assoc();
}
function LowStockProducts($conn)
{
    $result = $conn->query(
        "SELECT COUNT(*) AS total
         FROM products
         WHERE stock <= 5"
    );

    return $result->fetch_assoc();
}


}


?>