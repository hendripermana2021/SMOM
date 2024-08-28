<?php
require '../../db/connect.php';

if (isset($_POST['proseskelas'])) {
    // Sanitize input to prevent SQL Injection
    $control = mysqli_real_escape_string($koneksi, $_POST['control']);
    $name_kelas = mysqli_real_escape_string($koneksi, $_POST['name_kelas']);
    $tingkat = mysqli_real_escape_string($koneksi, $_POST['tingkat']);
    $walkes = mysqli_real_escape_string($koneksi, $_POST['walkes']);
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Handling optional 'id_class' only if it exists (for update or delete)
    $id_class = isset($_POST['id_class']) ? mysqli_real_escape_string($koneksi, $_POST['id_class']) : null;

    // Adjust query based on the control value
    if ($control == "add") {
        $insert = mysqli_query($koneksi, "INSERT INTO tbl_classes (name_class, grade_class, id_walkes, createdAt, updatedAt) 
                                          VALUES ('$name_kelas', '$tingkat', '$walkes', '$created_at', '$updated_at')");
    } else if ($control == "update" && $id_class) {
        $update = mysqli_query($koneksi, "UPDATE tbl_classes 
                                          SET name_class='$name_kelas', grade_class='$tingkat', id_walkes='$walkes', updatedAt='$updated_at'
                                          WHERE id='$id_class'");
    } else if ($control == "delete" && $id_class) {
        $delete = mysqli_query($koneksi, "DELETE FROM tbl_classes WHERE id='$id_class'");
    }

    // Handling the result of the queries
    if ((isset($insert) && $insert) || (isset($update) && $update) || (isset($delete) && $delete)) {
        $_SESSION["sukses"] = 'Data Berhasil Diproses';
    } else {
        $_SESSION["error"] = 'Gagal Proses';
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
