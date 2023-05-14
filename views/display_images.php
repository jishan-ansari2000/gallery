<?php


$user_email = $_SESSION['email'];

$query = "SELECT * FROM images_table where user_email = '$user_email' order by id desc";
$query_run = mysqli_query($conn, $query);

?>

<div class="container">

    <div class="row image_row">

        <?php

    if (mysqli_num_rows($query_run) > 0) {
      foreach ($query_run as $row) {

        $img = $row['path'] . $row['image_name'] . "-" . $row['upload_time'] . "." . $row['image_ext'];
        ?>

        <div class="col col-lg-3 col-md-4 mt-4" id="<?php echo $row['id']; ?>">
            <button onclick="show_updateImage_input(<?php echo $row['id']; ?>);">Edit</button>

            <form class="image_delete_form" >
                <input type="hidden" value="<?php echo $row['id']; ?>" name="image_id" />
                <input type="submit" name="delete_image" value="Delete"/>
            </form>

            <!-- ***********share Modal*********** -->

            <button class="btn btn-primary" data-bs-target="#shareModalToggle-<?php echo $row['id']; ?>" data-bs-toggle="modal">Open first modal</button>
            <div class="modal fade" id="shareModalToggle-<?php echo $row['id']; ?>" aria-hidden="true" aria-labelledby="shareModalToggleLabel-<?php echo $row['id']; ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="shareModalToggleLabel-<?php echo $row['id']; ?>">Copy Image Link!</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <p><?php echo "http://" . $_SERVER['HTTP_HOST'] ."/"."shared_image.php"."?img_id=". $row['id']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!---------- share Modal off ---------->

            <a href="detailed_image.php?id=<?php echo $row['id']; ?>"><img src="<?php echo $img ?>" alt="alex" /></a>
            <p class="image_title">
                <?php echo $row['image_name']; ?>
            </p>

            <form class="image_title_form">
                <div class="input-group">
                    <input type="hidden" name="image_id" value="<?php echo $row['id']; ?>" />
                    <input type="text" aria-label="Last name" class="form-control" name="image_name"
                        value="<?php echo $row['image_name']; ?>">
                    <button class="btn btn-outline-secondary" type="submit" style="display: none;"></button>
                </div>
            </form>

        </div>

        <?php
      }
    }
    ?>

    </div>

</div>