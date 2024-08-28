<?php
require '../../db/connect.php'; // Ensure this path is correct for your project

if (isset($_POST['prosesmodul'])) {
    // Sanitize input to prevent SQL injection
    $control = mysqli_real_escape_string($koneksi, $_POST['control']);
    $section = mysqli_real_escape_string($koneksi, $_POST['section']);
    $id_modul = mysqli_real_escape_string($koneksi, $_POST['id_modul']);
    $content = mysqli_real_escape_string($koneksi, $_POST['content']); // Assuming you are using a hidden input for content

    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    if ($control == "add") {
        // Insert query
        $insert = mysqli_query($koneksi, "INSERT INTO tbl_modul_contents (id_modul, section, content, createdAt, updatedAt) 
                                          VALUES ('$id_modul', '$section', '$content', '$created_at', '$updated_at')");

        // Check if the insert was successful
        if ($insert) {
            header('Location: ../../html/guru/tablemodul-detail.php?id=' . $id_modul);
            exit();
        } else {
            $_SESSION["error"] = 'Gagal Menambahkan Data';
        }
    }

    // Redirect to a success/failure page or back to the form
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
