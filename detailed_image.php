<?php include("views/header.php"); ?>

<!-- navbar includes top navbar as well as login signup models -->
<?php include("views/navbar.php"); ?>

<?php if (isset($_SESSION['email'])) {

    include("views/detailed_image_view.php");

} else {

    include("views/home_default.php");

} ?>

<?php include("views/footer.php"); ?>