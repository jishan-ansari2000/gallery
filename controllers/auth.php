<?php

session_start();

include("../config/connection.php");

function get_past_url($auth_type)
{
    // $queryString = http_build_query($queryArray);

    $past_queries_array = $_SESSION["current_queries"];
    $past_script_name = $_SESSION['current_script_name'];

    if($auth_type) {
        $past_queries_array['auth'] = $auth_type;
    } else {
        unset($past_queries_array['auth']);
    }

    $past_queries = http_build_query($past_queries_array);

    $past_url = "";
    if($past_queries) $past_url = $past_script_name . "?" . $past_queries;
    else $past_url = $past_script_name;

    return $past_url;
}

if (isset($_POST['signup'])) {
    $name = $_POST['signup_username'];
    $email = $_POST['signup_email'];
    $password = $_POST['signup_password'];
    $cpassword = $_POST['signup_cpassword'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $query_email = "SELECT * FROM user_table where email = '$email'";
    $query_email_run = mysqli_query($conn, $query_email);

    if ($query_email_run && mysqli_num_rows($query_email_run)) {

        $_SESSION['status'] = "Email is already registered!";

    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $_SESSION['status'] = "$email is not a valid email address";

    } else if ($password != $cpassword) {

        $_SESSION['status'] = "Password and Comfirm Password are not same";

    } else {
        $query = "INSERT INTO user_table (username, email, password) values('$name', '$email', '$password')";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['email'] = $email;
        } else {
            $_SESSION['status'] = "Registration Failed!";
        }
    }

    $past_url = get_past_url("signup");
    header("location:..{$past_url}");

}

if (isset($_POST['login'])) {

    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $query = "SELECT * FROM user_table where (email = '$email' && password = '$password')";
    $query_run = mysqli_query($conn, $query);


    if ($query_run && mysqli_num_rows($query_run) > 0) {
        $_SESSION['email'] = $email;
    } else {
        $_SESSION['status'] = "Email or password wrong";
    }

    $past_url = get_past_url("login");
    header("location:..{$past_url}");

}

if (isset($_POST['logout'])) {

    $current_url = get_past_url("");

    session_unset();

    header("location:..{$current_url}");

}

?>