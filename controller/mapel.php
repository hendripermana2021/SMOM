<?php
require '../../db/connect.php';

if (isset($_POST['prosesmapel'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';

    // Sanitize input to prevent SQL Injection
    $control = mysqli_real_escape_string($koneksi, $_POST['control']);
    $nama_mapel = mysqli_real_escape_string($koneksi, $_POST['nama_mapel']);
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Handling optional 'id_mapel' only if it exists (for update or delete)
    $id_mapel = isset($_POST['id_mapel']) ? mysqli_real_escape_string($koneksi, $_POST['id_mapel']) : null;

    // Adjust query based on the control value
    if ($control == "add") {
        $insert = mysqli_query($koneksi, "INSERT INTO tbl_mapel (nama_mapel, createdAt, updatedAt) VALUES ('$nama_mapel', '$created_at', '$updated_at')");
    } else if ($control == "update" && $id_mapel) {
        $update = mysqli_query($koneksi, "UPDATE tbl_mapel SET nama_mapel='$nama_mapel', updatedAt='$updated_at' WHERE id='$id_mapel'");
    } else if ($control == "delete" && $id_mapel) {
        $delete = mysqli_query($koneksi, "DELETE FROM tbl_mapel WHERE id='$id_mapel'");
    }

    // Handling the result of the queries
    if ((isset($insert) && $insert) || (isset($update) && $update) || (isset($delete) && $delete)) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Success",
                    text: "Data Berhasil Diproses",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "' . $_SERVER['PHP_SELF'] . '";
                    }
                });
            });
        </script>';
    } else {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Error",
                    text: "Gagal Proses",
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
    }

    exit;
}
