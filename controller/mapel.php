<?php
require '../../db/connect.php';

if (isset($_POST['prosesmapel'])) {
    // Sanitize input to prevent SQL Injection
    $control = mysqli_real_escape_string($koneksi, $_POST['control']);
    $nama_mapel = mysqli_real_escape_string($koneksi, $_POST['nama_mapel']);
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Handling optional 'id_mapel' only if it exists (for update or delete)
    $id_mapel = isset($_POST['id_mapel']) ? mysqli_real_escape_string($koneksi, $_POST['id_mapel']) : null;

    // Adjust query based on the control value
    if ($control == "add") {
        $insert = mysqli_query($koneksi, "INSERT INTO tbl_mapel (nama_mapel) VALUES ('$nama_mapel')");
    } else if ($control == "update" && $id_mapel) {
        $update = mysqli_query($koneksi, "UPDATE tbl_mapel 
                                          SET nama_mapel='$nama_mapel' WHERE id='$id_mapel'");
    } else if ($control == "delete" && $id_mapel) {
        $delete = mysqli_query($koneksi, "DELETE FROM tbl_mapel WHERE id='$id_mapel'");
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
