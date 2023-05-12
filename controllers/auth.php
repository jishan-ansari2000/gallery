<?php

session_start();

include("../config/connection.php");

echo $_POST['login'];

if(isset($_POST['login'])){
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $_SESSION['email'] = "jishanansari21064@gmail.com";

    header("location:../index.php");
}

if(isset($_POST['signup'])){
    $name = $_POST['signup_username'];
    $email = $_POST['signup_email'];
    $password = $_POST['signup_password'];
    $cpassword = $_POST['signup_cpassword'];
    
    echo $name."<br>";
    echo $email."<br>";
    echo $password."<br>";
    echo $cpassword."<br>";

    header("location:../index.php");
}



?>