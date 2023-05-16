<?php


$user_email = $_SESSION['email'];

$query = "SELECT * FROM images_table where user_email = '$user_email' && id in (SELECT image_id from deleted_images) order by id desc";
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

                        <div class="card-footer text-muted" style="height: 100%;">

                            <a href="detailed_image.php?id=<?php echo $row['id']; ?>">
                                <div 
                                    class="card-image-overlay" 
                                    onmouseover="imageMouseOver(<?php echo $row['id']; ?>)"
                                    onmouseout="imageMouseOut(<?php echo $row['id']; ?>)"
                                >

                                </div>
                            </a>

                            <div  
                                class="card-btn-container" 
                                onmouseover="btnMouseOver(<?php echo $row['id']; ?>)"
                                onmouseout="btnMouseOut(<?php echo $row['id']; ?>)"
                            >

                                <!-- edit button -->
                                <button class="btn btn-light restoreBtn" onclick="restoreImageFun(<?php echo $row['id']; ?>);" > 
                                    <i class="bi bi-arrow-counterclockwise"></i> Restore
                                </button>

                                <!-- delete button -->
                                <form class="bin_image_delete_form" style="display: inline-block;">
                                    <input type="hidden" value="<?php echo $row['id']; ?>" name="image_id" />
                                    <button class="btn" type="submit" name="delete_image" value="Delete">        
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                    <!-- <input /> -->
                                </form>
                            </div>

                            <!-- Image Title start -->

                            <p class="image_title">
                                <?php echo $row['image_name']; ?>
                            </p>

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
                            <h5 class="card-title">There are no any Deleted Images</h5>
                        </div>
                    </div>

                </div>
        <?php } ?>

    </div>

</div>