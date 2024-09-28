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
      echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
      echo '<script>
          document.addEventListener("DOMContentLoaded", function() {
              Swal.fire({
                    title: "Success",
                    text: "Anda Sudah Logout",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../../login.php";
                    }
                });
          });
      </script>';
   }
}
