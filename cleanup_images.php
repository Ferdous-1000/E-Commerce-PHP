<?php

require_once("Model/ProductModel.php");

$product =
new ProductModel();

$conn =
$product->OpenConn();

$result =
$product->GetAllProducts($conn);

$dbImages = [];

while($row = $result->fetch_assoc())
{
    $dbImages[] = $row['image'];
}

$folder =
"uploads/products/";

$files =
scandir($folder);

foreach($files as $file)
{
    if(
        $file != "."
        &&
        $file != ".."
    )
    {
        if(!in_array($file,$dbImages))
        {
            unlink($folder . $file);

            echo
            "Deleted: "
            .
            $file
            .
            "<br>";
        }
    }
}

echo "Cleanup Complete";
?>