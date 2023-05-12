<?php 
    error_reporting(0); //it removes all warning not Error

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gallery";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if($conn) {
        // echo "connection ok";
    } else {
        echo "connection failed".mysqli_connect_error();
    }

?>