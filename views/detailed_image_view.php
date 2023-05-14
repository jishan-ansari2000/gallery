<?php


    $user_email = $_SESSION['email'];
    $id = $_GET['id'];

    // $query = "SELECT * FROM images_table where user_email = '$user_email' && id <= '$id' order by id desc limit 4";
    $query_prev = "SELECT * FROM images_table where user_email = '$user_email' && id > '$id' order by id limit 1";
    $query_prev_run = mysqli_query($conn, $query_prev);

    $query = "SELECT * FROM images_table where user_email = '$user_email' && id <= '$id' order by id desc limit 2";
    $query_run = mysqli_query($conn, $query);

?> 


<div id="imageStatus">
    
</div>

<div id="imageCarousel" class="carousel carousel-dark slide">

    <div class="carousel-inner" id="carousel_container">

        <?php
        if (mysqli_num_rows($query_prev_run) > 0) {
            foreach ($query_prev_run as $row) {
            $img = $row['path'] . $row['image_name'] . "-" . $row['upload_time'] . "." . $row['image_ext'];
        ?>

            <div class="carousel-item"  style="height: 80vh;" data-value="<?php echo $row['id']; ?>">
                <img src="<?php echo $img ?>" class="d-block w-100" alt="<?php echo $row['image_name']; ?>">
                <div class="carousel-caption d-none d-md-block">
                    <h5><?php echo $row['image_name']; ?></h5>
                </div>
            </div>

        <?php }} ?>

        <?php
        if (mysqli_num_rows($query_run) > 0) {
            foreach ($query_run as $row) {
            $img = $row['path'] . $row['image_name'] . "-" . $row['upload_time'] . "." . $row['image_ext'];
        ?>

            <div class="carousel-item <?php if($row['id'] == $id) echo 'active' ?>"  style="height: 80vh;" data-value="<?php echo $row['id']; ?>">
                <img src="<?php echo $img ?>" class="d-block w-100" alt="<?php echo $row['image_name']; ?>">
                <div class="carousel-caption d-none d-md-block">
                    <h5><?php echo $row['image_name']; ?></h5>
                </div>
            </div>

        <?php }} ?>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev" style="background-color: gray:">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

