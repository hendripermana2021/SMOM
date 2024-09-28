<?php
require '../../db/connect.php';

if (isset($_POST['prosessiswa'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
    // Melakukan sanitasi input untuk menghindari SQL Injection
    $control = mysqli_real_escape_string($koneksi, $_POST['control']);
    $name_siswa = mysqli_real_escape_string($koneksi, $_POST['name_siswa']);
    $sex = mysqli_real_escape_string($koneksi, $_POST['sex']);
    $id_class = mysqli_real_escape_string($koneksi, $_POST['kelas']); // Assuming 'kelas' corresponds to 'id_class'
    $fathername = mysqli_real_escape_string($koneksi, $_POST['namaayah']);
    $mothername = mysqli_real_escape_string($koneksi, $_POST['namaibu']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $real_password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $role_id = 3;
    $password_hashed = password_hash($real_password, PASSWORD_BCRYPT); // Hash password menggunakan bcrypt
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Handling optional 'id_siswa' only if it exists (e.g., for update or delete)
    $id_siswa = isset($_POST['id_siswa']) ? mysqli_real_escape_string($koneksi, $_POST['id_siswa']) : null;

    // Adjust query based on the control value
    if ($control == "add") {
        $insert = mysqli_query($koneksi, "INSERT INTO tbl_siswas (name_siswa, sex, id_class, fathername, mothername, status, email, password, real_password, createdAt, updatedAt, role_id) VALUES ('$name_siswa', '$sex', '$id_class', '$fathername', '$mothername', '$status', '$email', '$password_hashed', '$real_password', '$created_at','$updated_at', '$role_id')");
    } else if ($control == "update" && $id_siswa) {
        $update = mysqli_query($koneksi, "UPDATE tbl_siswas 
                  SET name_siswa='$name_siswa', sex='$sex', id_class='$id_class', fathername='$fathername', mothername='$mothername', status='$status', email='$email', password='$password_hashed', real_password='$real_password', updatedAt='$updated_at'
                  WHERE id='$id_siswa'");
    } else if ($control == "delete" && $id_siswa) {
        $delete = mysqli_query($koneksi, "DELETE FROM tbl_siswas WHERE id='$id_siswa'");
    }

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
