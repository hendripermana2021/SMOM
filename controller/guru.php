<?php
require '../../db/connect.php';

if (isset($_POST['prosesguru'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';

    // Melakukan sanitasi input untuk menghindari SQL Injection
    $control = mysqli_real_escape_string($koneksi, $_POST['control']);
    $name_user = mysqli_real_escape_string($koneksi, $_POST['name_user']);
    $bid_pendidikan = mysqli_real_escape_string($koneksi, $_POST['bid_pendidikan']);
    $pendidikan = mysqli_real_escape_string($koneksi, $_POST['pendidikan']);
    $sex = mysqli_real_escape_string($koneksi, $_POST['sex']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $real_password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $password_md5 = md5($real_password); // Password hashed using md5
    $role_id = 2;
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Handling optional 'id_guru' only if it exists (e.g., for update or delete)
    $id_user = isset($_POST['id_user']) ? mysqli_real_escape_string($koneksi, $_POST['id_user']) : null;

    // Adjust query based on the control value
    if ($control == "add") {
        $insert = mysqli_query($koneksi, "INSERT INTO tbl_gurus (name_guru, bid_pendidikan, role_id, pendidikan, sex, email, password, real_password, createdAt, updatedAt) 
                                          VALUES ('$name_user','$bid_pendidikan', '$role_id', '$pendidikan', '$sex', '$email', '$password_md5', '$real_password', '$created_at','$updated_at')");
    } else if ($control == "update" && $id_user) {
        $update = mysqli_query($koneksi, "UPDATE tbl_gurus 
                                          SET name_guru='$name_user', bid_pendidikan='$bid_pendidikan', pendidikan='$pendidikan', sex='$sex', email='$email', password='$password_md5', real_password='$real_password'
                                          WHERE id='$id_user'");
    } else if ($control == "delete" && $id_user) {
        $delete = mysqli_query($koneksi, "DELETE FROM tbl_gurus WHERE id='$id_user'");
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
