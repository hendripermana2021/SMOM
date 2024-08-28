<?php
error_reporting(0);
require '../db/connect.php';
if (isset($_POST['register'])) {
   $nik = $_POST['nik'];
   $check_karyawan = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE nik='$nik'");
   $data_karyawan = mysqli_fetch_array($check_karyawan);
   $nama = $data_karyawan['nama'];
   if ($nama == NULL) {
      $_SESSION["error"] = 'Anda Belum Terdaftar Sebagai Petugas di Rumah Sakit, silahkan hubungi admin rumah sakit untuk mendaftarkan diri anda untuk mendapatkan akses register user simrs ';
      $_SESSION['redirectlogin'] = 'auth/register';
   } else {
      $username = $_POST['username'];
      $check_user = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
      $data_user = mysqli_fetch_array($check_user);
      $user_id = $data_user['username'];
      if ($user_id == $username) {
         $_SESSION["error"] = 'Username Anda Telah Terdaftar, Anda tidak dapat menambahkan user access ini, silahkan reset password anda atau hubungi admin untuk membuka akses anda kembali';
         $_SESSION['redirectlogin'] = 'auth/forgot-password';
      } else {
         $pass = md5($_POST['password']);
         $role = $_POST['role'];
         $uid = md5($_POST['nik']);
         $insert = mysqli_query($koneksi, "INSERT INTO user (uid, fullname, username, password, path, roles)VALUES('$uid','$nama','$username','$pass','$role','$role')");
         if ($insert) {
            $_SESSION["sukses"] = 'Berhasil Registerasi, Silahkan Login';
            $_SESSION['redirectlogin'] = 'auth/index';
         }
      }
   }
}
