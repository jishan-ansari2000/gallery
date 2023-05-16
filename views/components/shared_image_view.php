<?php
$id = $_GET['img_id'];


$query = "SELECT * FROM images_table where id = '$id'";
$query_run = mysqli_query($conn, $query);

if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
        $img  = $row['path'] . $row['image_name'] . "-" . $row['upload_time'] . "." . $row['image_ext'];
        $img = "../../" . $img;
        ?>
            <div class="shareImageBox">
                <img src="<?php echo $img; ?>" alt="<?php $row['image_name']; ?>" />
                <p>
                    <?php echo $row['image_name']; ?>
                </p>
            </div>
        <?php
    }
}

?>