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

                // echo date('d/m/Y', $row["upload_time"]);
        
                $img = $row['path'] . $row['image_name'] . "-" . $row['upload_time'] . "." . $row['image_ext'];
                $img = "../../" . $img;

                ?>

                <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mt-4" id="<?php echo $row['id']; ?>">

                    <div class="card shadow-sm" style="height: 100%;">
                        <img src="<?php echo $img ?>" class="card-img-top" alt="...">

                        <!-- <div class="card-body" style="padding: 0;">
                        </div> -->

                        <div class="card-footer text-muted" style="height: 100%;">

                            <a href="detailed_image.php?id=<?php echo $row['id']; ?>">
                                <div class="card-image-overlay" onmouseover="imageMouseOver(<?php echo $row['id']; ?>)"
                                    onmouseout="imageMouseOut(<?php echo $row['id']; ?>)">
                                </div>
                            </a>

                            <div class="card-btn-container" onmouseover="btnMouseOver(<?php echo $row['id']; ?>)"
                                onmouseout="btnMouseOut(<?php echo $row['id']; ?>)">

                                <!-- edit button -->
                                <button class="btn" onclick="show_updateImage_input(<?php echo $row['id']; ?>);"> 
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- delete button -->
                                <form class="image_delete_form" style="display: inline-block;">
                                    <input type="hidden" value="<?php echo $row['id']; ?>" name="image_id" />
                                    <button class="btn" type="submit" name="delete_image" value="Delete">        
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                    <!-- <input /> -->
                                </form>

                                 <!-- share button -->
                                <button class="btn" data-bs-target="#shareModalToggle-<?php echo $row['id']; ?>"  
                                    data-bs-toggle="modal">                                                        
                                    <i class="bi bi-share-fill"></i>
                                </button>
                            </div>

                            <!-- ***********share Modal start*********** -->

                            <div class="modal fade" id="shareModalToggle-<?php echo $row['id']; ?>" aria-hidden="true"
                                aria-labelledby="shareModalToggleLabel-<?php echo $row['id']; ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="shareModalToggleLabel-<?php echo $row['id']; ?>">
                                                Copy Image Link!</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="input-group mb-3">
                                                <p>
                                                    <?php echo "http://" . $_SERVER['HTTP_HOST'] . "/views/pages/" . "shared_image.php" . "?img_id=" . $row['id']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!---------- share Modal End ---------->


                            <!-- Image Title start -->

                            <p class="image_title">
                                <?php echo $row['image_name']; ?>
                            </p>

                            <form class="image_title_form">
                                <div class="input-group">
                                    <input type="hidden" name="image_id" value="<?php echo $row['id']; ?>" />
                                    <input type="text" aria-label="Image name" class="form-control" name="image_name"
                                        value="<?php echo $row['image_name']; ?>">
                                    <button class="btn btn-outline-secondary" type="submit" style="display: none;"></button>
                                </div>
                            </form>
                            <!-- Image Title End -->
                        </div>
                    </div>
                </div>

                <?php
            }
        } else {
            ?>
            <div class="home_default">

                <div class="card border-warning shadow-lg home_default_card">

                    <div class="card-body">
                        <h5 class="card-title">There are no any uploaded Images</h5>
                        <p class="card-text">Please Upload your Images</p>
                        <button 
                            class="btn btn-success uploadBtn" 
                            data-bs-target="#imageUploadModal" 
                            data-bs-toggle="modal" 
                            style="position: static;"
                        >
                            <i class="bi bi-upload"></i> Upload Images
                        </button>
                    </div>
                </div>

            </div>
        <?php } ?>

    </div>

</div>