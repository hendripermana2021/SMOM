<?php
error_reporting(0);
require '../db/connect.php';
if (isset($_POST['caripoli'])) {
   $uid = $_POST['uid'];
   $poli = $_POST['poli'];
   $update = mysqli_query($koneksi, "UPDATE user SET poli='$poli' WHERE uid='$uid' ");
   if ($update) {
      $_SESSION['poli'] = $poli;
      $path = $_POST['path'];
      $_SESSION["sukses"] = 'Anda Masuk Di Poliklinik  ' . $poli;
      $_SESSION['redirectlogin'] = 'module/' . $path;
   } else {
      $_SESSION["error"] = 'Poliklnik Tidak Terdaftar';
   }
}
