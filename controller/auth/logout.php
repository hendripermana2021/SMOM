<?php
require '../../db/connect.php';

$user_id = $_GET['id'];
$role = $_GET['role'];
$email = $_GET['email'];

// Check if the role is either 1 or 2
if ($role == 1 || $role == 2) {
   $check_user = mysqli_query($koneksi, "SELECT * FROM tbl_gurus WHERE id='$user_id' AND email='$email'");
} else {
   $check_user = mysqli_query($koneksi, "SELECT * FROM tbl_siswas WHERE id='$user_id' AND email='$email'");
}

$data_user = mysqli_fetch_array($check_user);

if ($data_user) {
   $user = $data_user['email'];
   if ($user != NULL) {
      session_start();
      // Unset all session variables
      session_unset();
      // Destroy the session
      session_destroy();

      echo "<script>alert('Anda Telah Mengakhiri Sesi Aplikasi');
      document.location='../../login.php'</script>";
      exit(); // Stop further execution after session destruction
   }
   echo 'end1';
} else {
   echo 'end2';
}
