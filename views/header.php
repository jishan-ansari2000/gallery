<?php

session_start();
include("config/connection.php");

$_SESSION["current_script_name"] = $_SERVER['SCRIPT_NAME'];
$_SESSION["current_url"] = $_SERVER['REQUEST_URI'];

parse_str($_SERVER['QUERY_STRING'], $query_array);
$_SESSION["current_queries"] = $query_array;

if($_SESSION["current_url"] != "/") 
    $_SESSION["not_loggedIn"] = "You are not Logged In, Please Login to access this route!";
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- for adding a jQuery -->
    <title>Gallery</title>
</head>

<body>