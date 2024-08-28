<?php
require '../../db/connect.php';

if (isset($_POST['prosessiswa'])) {
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
    $password_md5 = md5($real_password); // Password hashed 
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Handling optional 'id_siswa' only if it exists (e.g., for update or delete)
    $id_siswa = isset($_POST['id_siswa']) ? mysqli_real_escape_string($koneksi, $_POST['id_siswa']) : null;

    // Adjust query based on the control value
    if ($control == "add") {
        $insert = mysqli_query($koneksi, "INSERT INTO tbl_siswas (name_siswa, sex, id_class, fathername, mothername, status, email, password, real_password, createdAt, updatedAt, role_id) 
                                          VALUES ('$name_siswa', '$sex', '$id_class', '$fathername', '$mothername', '$status', '$email', '$password_md5', '$real_password', '$created_at','$updated_at', '$role_id')");
    } else if ($control == "update" && $id_siswa) {
        $update = mysqli_query($koneksi, "UPDATE tbl_siswas 
                                          SET name_siswa='$name_siswa', sex='$sex', id_class='$id_class', fathername='$fathername', mothername='$mothername', status='$status', email='$email', password='$password_md5', real_password='$real_password', updatedAt='$updated_at'
                                          WHERE id='$id_siswa'");
    } else if ($control == "delete" && $id_siswa) {
        $delete = mysqli_query($koneksi, "DELETE FROM tbl_siswas WHERE id='$id_siswa'");
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
