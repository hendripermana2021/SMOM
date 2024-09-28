<?php
require '../../db/connect.php';

if (isset($_POST['prosesmodul'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';

    // Melakukan sanitasi input untuk menghindari SQL Injection
    $control = mysqli_real_escape_string($koneksi, $_POST['control']);
    $title = mysqli_real_escape_string($koneksi, $_POST['title']);
    $subtitle = mysqli_real_escape_string($koneksi, $_POST['subtitle']);
    $tingkat = mysqli_real_escape_string($koneksi, $_POST['tingkat']);
    $status_post = mysqli_real_escape_string($koneksi, $_POST['status_post']);
    $type_modul = mysqli_real_escape_string($koneksi, $_POST['type_modul']);
    $statusActive = 'Active';
    $user_id = mysqli_real_escape_string($koneksi, $_POST['user_id']);
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');
    $imageUpdate = isset($_POST['image']) ? $_POST['image'] : null;
    $pdfUpdate = isset($_POST['uploadPdf']) ? $_POST['uploadPdf'] : null;

    // Handling optional 'id_modul'
    $id_modul = isset($_POST['id_modul']) ? mysqli_real_escape_string($koneksi, $_POST['id_modul']) : null;

    // Handle image upload
    $image = isset($_FILES['image']['name']) && $_FILES['image']['name'] != "" ? $_FILES['image']['name'] : $imageUpdate;
    $target_dir = "../../assets/img/uploads/";
    $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

    if ($image) {
        $new_image_name = date('YmdHis') . '.' . $imageFileType;
        $target_file = $target_dir . $new_image_name;
    }

    // Handle PDF upload
    $filePdf = isset($_FILES['uploadPdf']['name']) && $_FILES['uploadPdf']['name'] != "" ? $_FILES['uploadPdf']['name'] : $pdfUpdate;
    $target_dir_pdf = "../../assets/pdf/uploads/";
    $pdfFileType = strtolower(pathinfo($filePdf, PATHINFO_EXTENSION));

    if ($filePdf) {
        $new_pdf_name = date('YmdHis') . '.' . $pdfFileType;
        $target_file_pdf = $target_dir_pdf . $new_pdf_name;
    }

    // Initialize upload flags
    $uploadOk = 1;
    $upload_pdf_ok = 1;

    // Validate image file size
    if (isset($_FILES["image"]["size"]) && $_FILES["image"]["size"] > 500000) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Warning",
                    text: "Image terlalu besar, di atas 5MB",
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.history.back();
                    }
                });
            });
        </script>';
        exit();
    }

    // Upload image if validation passed
    if ($uploadOk && isset($_FILES["image"]["tmp_name"]) && $_FILES["image"]["tmp_name"] != "") {
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Warning",
                        text: "Maaf, terjadi kesalahan saat mengunggah file gambar.",
                        icon: "warning",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Ok"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.history.back();
                        }
                    });
                });
            </script>';
            exit();
        }
    }

    // Upload PDF if validation passed
    if ($upload_pdf_ok && isset($_FILES["uploadPdf"]["tmp_name"]) && $_FILES["uploadPdf"]["tmp_name"] != "") {
        if (!move_uploaded_file($_FILES["uploadPdf"]["tmp_name"], $target_file_pdf)) {
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Warning",
                        text: "Maaf, terjadi kesalahan saat mengunggah file PDF.",
                        icon: "warning",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Ok"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.history.back();
                        }
                    });
                });
            </script>';
            exit();
        }
    }

    // Adjust query based on the control value
    if ($control == "add") {
        $insert = mysqli_query($koneksi, "INSERT INTO tbl_moduls (title, id_guru, subtitle, status_post, for_class, image, filePdf, createdAt, updatedAt, type_modul) VALUES ('$title', '$user_id', '$subtitle', '$statusActive', '$tingkat', '$new_image_name', '$new_pdf_name', '$created_at', '$updated_at', '$type_modul')");
    } else if ($control == "update" && $id_modul) {
        $updateQuery = "UPDATE tbl_moduls SET title='$title', subtitle='$subtitle', status_post='$status_post', for_class='$tingkat', updatedAt='$updated_at'";
        $updateQuery .= $image ? ", image='$new_image_name'" : "";
        $updateQuery .= $filePdf ? ", filePdf='$new_pdf_name'" : "";
        $updateQuery .= " WHERE id='$id_modul'";
        $update = mysqli_query($koneksi, $updateQuery);
    } else if ($control == "delete" && $id_modul) {
        $delete = mysqli_query($koneksi, "DELETE FROM tbl_moduls WHERE id='$id_modul'");
    }

    // Handling the result of the queries
    if ((isset($insert) && $insert) || (isset($update) && $update) || (isset($delete) && $delete)) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Success",
                    text: "Data berhasil diproses.",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../admin/tablemodul.php";
                    }
                });
            });
        </script>';
        exit();
    } else {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Error",
                    text: "Gagal memproses data.",
                    icon: "error",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.history.back();
                    }
                });
            });
        </script>';
        exit();
    }
}
