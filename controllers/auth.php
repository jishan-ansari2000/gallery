<?php

session_start();

include("../config/connection.php");

if(isset($_POST['login'])){
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $query = "SELECT * FROM user_table where (email = '$email' && password = '$password')";
    $query_run = mysqli_query($conn, $query);

    echo mysqli_num_rows($query_run);

    if($query_run && mysqli_num_rows($query_run) > 0) {
        $_SESSION['email'] = $email;
        header("location:../index.php");
    } else {
        $_SESSION['status'] = "Email or password wrong";
        header('location:../index.php');
    }

}

if(isset($_POST['signup'])){
    $name = $_POST['signup_username'];
    $email = $_POST['signup_email'];
    $password = $_POST['signup_password'];
    $cpassword = $_POST['signup_cpassword'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if($password != $cpassword) {

        $_SESSION['status'] = "Password and Comfirm Password are not same";
        header('location:../index.php?auth=signup');

    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $_SESSION['status'] = "$email is not a valid email address";
        header('location:../index.php?auth=signup');

    } else {
        $query = "INSERT INTO user_table (username, email, password) values('$name', '$email', '$password')";
        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            $_SESSION['email'] = $email;
            header("location:../index.php");
        } else {
            $_SESSION['status'] = "Registration Failed!";
            header('location:../index.php?auth=signup');
        }


    }
    
}



// Remove all illegal characters from email


// Validate e-mail
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo("$email is a valid email address");
} else {
    echo("$email is not a valid email address");
}




?>