<?php

session_start();

include("../config/connection.php");



if (isset($_POST['upload'])) {
    $user_email = $_SESSION['email'];
    $images = $_FILES['gallery_images'];

    $path = "assets/images/user_uploaded/";
    $allowed_extensions = array('gif', 'png', 'jpg', 'jpeg');

    $current_time = time(); // Get the current time

    if (!empty($images['name'])) {
        foreach ($images['name'] as $key => $image) {

            $filename = $images["name"][$key];
            $tempname = $images["tmp_name"][$key];

            // Image validation 

            // $file_dirname = pathinfo($filename, PATHINFO_DIRNAME);
            // $file_basename = pathinfo($filename, PATHINFO_BASENAME); //with extension
            $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
            $file_filename = pathinfo($filename, PATHINFO_FILENAME); //without extension

            if (!in_array($file_extension, $allowed_extensions)) {
                $_SESSION['status'] = "You are allowed with only jpg png jpeg and gig";
                header('location: ../index.php');
            } else {

                $query = "INSERT INTO images_table (path, user_email, image_name, image_ext, upload_time) values ('$path','$user_email', '$file_filename', '$file_extension', '$current_time' )";
                $query_run = mysqli_query($conn, $query);

                if ($query_run) {
                    $_SESSION['status'] = "Image stored successfully";

                    $folder = $path . $file_filename . "-" . $current_time . "." . $file_extension;
                    move_uploaded_file($tempname, "../" . $folder);

                    header('location: ../index.php');
                } else {
                    $_SESSION['status'] = "Image Not Inserted";
                    header('location: ../index.php');
                }

            }

        }
    }

}


if (isset($_POST['update_image'])) {
    $id = $_POST['id'];
    $image_name = $_POST['image_name'];

    $user_email = $_SESSION['email'];

    $get_query = "SELECT * FROM images_table where id = '$id' && user_email = '$user_email'";
    $get_query_run = mysqli_query($conn, $get_query);

    $old_img = "";
    $new_img = "";

    if (mysqli_num_rows($get_query_run) > 0) {
        foreach ($get_query_run as $row) {
            $old_img = $row['path'] . $row['image_name'] . "-" . $row['upload_time'] . "." . $row['image_ext'];
            $new_img = $row['path'] . $image_name . "-" . $row['upload_time'] . "." . $row['image_ext'];
        }
    }

    $query = "UPDATE images_table set image_name = '$image_name' where id = '$id'";
    $query_run = mysqli_query($conn, $query);

    $result = [
        "status" => "",
        "image_name" => "",
    ];

    if($query_run) {
        if(rename("../".$old_img, "../".$new_img)) {
            $result["status"] = "success";
            $result["image_name"] = $image_name;
        } else {
            $result["status"] = "image not renamed";
        }
    } else {
        $result["status"] = "query failed";
    }

    echo json_encode($result);
}

if (isset($_POST['delete_image'])) {

    $id = $_POST['id'];
    $user_email = $_SESSION['email'];

    $get_query = "SELECT * FROM images_table where id = '$id' && user_email = '$user_email'";
    $get_query_run = mysqli_query($conn, $get_query);

    $old_img = "";
    $target_image_name = "";
    if (mysqli_num_rows($get_query_run) > 0) {
        foreach ($get_query_run as $row) {
            $old_img = $row['path'] . $row['image_name'] . "-" . $row['upload_time'] . "." . $row['image_ext'];
            $target_image_name = $row['image_name'];
        }
    }
    $set_delete_query = "INSERT INTO deleted_images (image_id) values ('$id')";

    $set_delete_query_run = mysqli_query($conn, $set_delete_query);


    // $query = "DELETE FROM images_table where id = '$id' && user_email = '$user_email'";
    // $query_run = mysqli_query($conn, $query);

    $result = [
        "status" => "",
        "image_id" => "",
    ];

    // if ($query_run) {
    //     unlink("../" . $old_img);
    //     $result["status"] = "success";
    //     $result["image_id"] = $id;
    // } else {
    //     $result["status"] = "failed";
    //     $result["image_id"] = $id;
    // }

    if ($set_delete_query_run) {
        $result["status"] = "success";
        $result["image_id"] = $id;
    } else {
        $result["status"] = "failed";
        $result["image_id"] = $id;
    }

    echo json_encode($result);
}

if (isset($_POST['bin_image_delete_form'])) {

    $id = $_POST['id'];
    $user_email = $_SESSION['email'];

    $get_query = "SELECT * FROM images_table where id = '$id' && user_email = '$user_email'";
    $get_query_run = mysqli_query($conn, $get_query);

    $old_img = "";
    $target_image_name = "";
    if (mysqli_num_rows($get_query_run) > 0) {
        foreach ($get_query_run as $row) {
            $old_img = $row['path'] . $row['image_name'] . "-" . $row['upload_time'] . "." . $row['image_ext'];
            $target_image_name = $row['image_name'];
        }
    }

    $query = "DELETE FROM images_table where id = '$id' && user_email = '$user_email'";
    $query_run = mysqli_query($conn, $query);

    $result = [
        "status" => "",
        "image_id" => "",
    ];

    if ($query_run) {
        unlink("../" . $old_img);
        $result["status"] = "success";
        $result["image_id"] = $id;

        $query_deleted = "DELETE FROM deleted_images where image_id = '$id'";
        $query_deleted_run = mysqli_query($conn, $query_deleted);

    } else {
        $result["status"] = "failed";
        $result["image_id"] = $id;
    }

    echo json_encode($result);
}

if (isset($_POST['restoreImage'])) {

    $id = $_POST['id'];

    

    $query = "DELETE FROM deleted_images where image_id = '$id'";
    $query_run = mysqli_query($conn, $query);

    $result = [
        "status" => "",
        "image_id" => "",
    ];

    if ($query_run) {
        $result["status"] = "success";
        $result["image_id"] = $id;

    } else {
        $result["status"] = "failed";
        $result["image_id"] = $id;
    }

    echo json_encode($result);
}



if( isset( $_POST['next_image'] ) ) {
    $id= $_POST['id'];

    $user_email = $_SESSION['email'];

    $result = [
        "status"=> "success",
        "images" => $id
    ];

    $query = "SELECT * FROM images_table where user_email = '$user_email' && id < '$id' order by id desc limit 5";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) > 0) {
        $rows = $query_run->fetch_all(MYSQLI_ASSOC);
        $result['images'] = $rows;
    } else {
        $result["status"] = "zeroImages";
        $result["message"] = "There is no any image left!";
    }

    echo json_encode($result);
}

if( isset( $_POST['prev_image'] ) ) {
    $id= $_POST['id'];

    $user_email = $_SESSION['email'];

    $result = [
        "status"=> "success",
        "images" => $id
    ];

    $query = "SELECT * FROM images_table where user_email = '$user_email' && id > '$id' order by id limit 5";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) > 0) {
        $rows = $query_run->fetch_all(MYSQLI_ASSOC);
        $result['images'] = $rows;
    } else {
        $result["status"] = "zeroImages";
        $result["message"] = "There is no any image left!";
    }

    echo json_encode($result);
}

if(isset($_POST['set_session_id_forurl'])) {
    
    $_SESSION['current_queries']['id'] = $_POST['image_id'];

 

    echo json_encode($_SESSION['current_queries']);

    // echo $_POST['image_id'];
}

?>
