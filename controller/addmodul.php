<?php
require '../../db/connect.php';

if (isset($_POST['prosesmodul'])) {
    // Melakukan sanitasi input untuk menghindari SQL Injection
    $control = mysqli_real_escape_string($koneksi, $_POST['control']);
    $title = mysqli_real_escape_string($koneksi, $_POST['title']);
    $subtitle = mysqli_real_escape_string($koneksi, $_POST['subtitle']);
    $tingkat = mysqli_real_escape_string($koneksi, $_POST['tingkat']);
    $status_post = mysqli_real_escape_string($koneksi, $_POST['status_post']);
    $status_active = 'Active';
    $user_id = mysqli_real_escape_string($koneksi, $_POST['user_id']);

    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Handling optional 'id_modul' only if it exists (e.g., for update or delete)
    $id_modul = isset($_POST['id_modul']) ? mysqli_real_escape_string($koneksi, $_POST['id_modul']) : null;

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target_dir = "../assets/img/uploads/"; // Make sure this directory exists
    $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

    // Create a unique image name using the current date and time
    $new_image_name = date('YmdHis') . '.' . $imageFileType;
    $target_file = $target_dir . $new_image_name;

    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) { // Adjust the file size limit as needed
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($new_image_name)) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Adjust query based on the control value
    if ($control == "add") {
        $insert = mysqli_query($koneksi, "INSERT INTO tbl_moduls (title, id_guru, subtitle, status_post, for_class, image, createdAt, updatedAt) 
                                          VALUES ('$title','$user_id', '$subtitle', '$status_active', '$tingkat', '$new_image_name', '$created_at', '$updated_at')");
    } else if ($control == "update" && $id_modul) {
        $update = mysqli_query($koneksi, "UPDATE tbl_moduls 
                                          SET title='$title', subtitle='$subtitle', status_post='$status_post', for_class='$tingkat', image='$new_image_name', updatedAt='$updated_at'
                                          WHERE id='$id_modul'");
    } else if ($control == "delete" && $id_modul) {
        $delete = mysqli_query($koneksi, "DELETE FROM tbl_moduls WHERE id='$id_modul'");
    }

    // Handling the result of the queries
    if ((isset($insert) && $insert) || (isset($update) && $update) || (isset($delete) && $delete)) {
        $_SESSION["sukses"] = 'Data Berhasil Diproses';
    } else {
        $_SESSION["error"] = 'Gagal Proses';
    }

    header('Location: ../html/admin/tablemodul.php');
    exit();
}
