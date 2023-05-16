<?php include("views/header.php"); ?>

<!-- navbar includes top navbar as well as login signup models -->
<?php include("views/navbar.php"); ?>

<?php if (isset($_SESSION['email'])) {

  include("views/image_upload_form.php");

  include("views/display_images.php");

} else {

  include("views/home_default.php");

} ?>




<?php
  // echo $_SERVER['QUERY_STRING'] . "<br>";
  // echo $_SERVER['SCRIPT_NAME'] . "<br>";
  // echo $_SERVER['DOCUMENT_ROOT'] . "<br>";

  // parse_str($_SERVER['QUERY_STRING'], $query_array);
  // print_r($query_array);

?>

<?php include("views/footer.php"); ?>