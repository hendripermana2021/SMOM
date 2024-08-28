<?php
error_reporting(0);
require '../db/connect.php';
if (isset($_POST['reset'])) {
   $user = $_POST['user'];
   $check = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$user'");
   $data = mysqli_fetch_array($check);
   $uid = $data['uid'];
   if ($uid != NULL) {
      $pass = rand(1111, 9999);
      $passenc = md5($pass);
      $update = mysqli_query($koneksi, "UPDATE user SET password='$passenc' WHERE username='$user' ");
      if ($update) {
         $_SESSION["sukses"] = 'Password anda berhasil di reset :  ' . $pass;
         $_SESSION['redirectlogin'] = 'index';
      } else {
         $_SESSION["error"] = 'Gagal Update Password';
      }
   } else {
      $_SESSION["error"] = 'Username anda tidak terdaftar';
   }
}
