
<?php
require '../../db/connect.php';
$user_id = $_GET['id'];
$role = $_GET['role'];
$email = $_GET['email'];

if ($role == 1 || 2) {
   $check_user = mysqli_query($koneksi, "SELECT * FROM tbl_gurus WHERE id='$user_id' AND email='$email'");
} else if ($role == 3) {
   $check_user = mysqli_query($koneksi, "SELECT * FROM tbl_siswas WHERE id='$$user_id' AND email='$email'");
}
$data_user = mysqli_fetch_array($check_user);
if ($data_user) {
   $user = $data_user['email'];
   // $stamp = date('Y-m-d H:i:s');
   // $update_session = mysqli_query($koneksi, "UPDATE user SET logout_at='$stamp' WHERE uid='$uid'");
   if ($user != NULL) {
      session_start();
      unset($_SESSION['name_user']);
      unset($_SESSION['sex']);
      unset($_SESSION['bid_pendidikan']);
      unset($_SESSION['pendidikan']);
      unset($_SESSION['email']);
      unset($_SESSION['user_id']);
      unset($_SESSION['role_id']);
      session_destroy();
      echo " <script>alert ('Anda Telah Mengakhiri Session Aplikasi');
      document.location='../../html/login/login.php'</script>";
   }
}
