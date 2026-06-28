<?php

class Model
{
    public function OpenConn()
    {
        $conn = new mysqli(
            "localhost",
            "root",
            "",
            "ecommerce"
        );

        if($conn->connect_error)
        {
            die("Connection Failed");
        }

        return $conn;
    }

    public function CloseConn($conn)
    {
        $conn->close();
    }
}

?>