<?php


$user_email = $_SESSION['email'];

$query = "SELECT * FROM images_table where user_email = '$user_email' order by id desc";
$query_run = mysqli_query($conn, $query);

?>

<div class="container">
    
    <?php

  if (isset($_SESSION['status']) && !isset($_GET['auth'])) {
    ?>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Hey! </strong>
        <?php echo $_SESSION['status'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    unset($_SESSION['status']);
  }
  ?>

    <div class="row image_row">

        <?php

    if (mysqli_num_rows($query_run) > 0) {
      foreach ($query_run as $row) {

        $img = $row['path'] . $row['image_name'] . "-" . $row['upload_time'] . "." . $row['image_ext'];
        ?>

        <div class="col col-lg-3 col-md-4 mt-4" id="<?php echo $row['id']; ?>">
            <button onclick="show_updateImage_input(<?php echo $row['id']; ?>);">Edit</button>

            <form action="controllers/image_handler.php" method="POST" onsubmit="return confirm('Are you sure you want to delete the Image');">
                <input type="hidden" value="<?php echo $row['id']; ?>" name="id" />
                <input type="submit" name="delete_image" value="Delete"/>
                <!-- <input type='submit' value='Delete' onclick = 'return checkdelete()'> -->
            </form>

            <a href="detailed_image.php?id=<?php echo $row['id']; ?>"><img src="<?php echo $img ?>" alt="alex" /></a>
            <p class="image_title">
                <?php echo $row['image_name']; ?>
            </p>

            <div class="image_title_form">
                <div class="input-group">
                    <input type="hidden" name="image_id" value="<?php echo $row['id']; ?>" />
                    <input type="text" aria-label="Last name" class="form-control" name="image_name"
                        value="<?php echo $row['image_name']; ?>">
                    <button class="btn btn-outline-secondary"
                        onclick="submit_update_image(<?php echo $row['id']; ?>);">Button</button>
                </div>
            </div>

        </div>

        <?php
      }
    }
    ?>

    </div>

</div>