<?php
require '../../db/connect.php';
session_start();

if (isset($_POST['login'])) {
   $email = mysqli_real_escape_string($koneksi, $_POST['email']);
   $password = mysqli_real_escape_string($koneksi, $_POST['password']);
   $role = mysqli_real_escape_string($koneksi, $_POST['role']);
   $err = '';

   if (empty($email) || empty($password)) {
      $err .= "<li>Silakan masukkan email dan juga password.</li>";
   } else {
      // Determine the SQL query based on role
      if ($role == 1 || $role == 2) {
         $sql = "SELECT * FROM tbl_gurus WHERE email = '$email'";
      } elseif ($role == 3) {
         $sql = "SELECT * FROM tbl_siswas WHERE email = '$email'";
      } else {
         $err .= "<li>Role tidak valid.</li>";
         $sql = ''; // Prevent further SQL execution
      }

      if ($sql) {
         $q = mysqli_query($koneksi, $sql);

         if (mysqli_num_rows($q) > 0) {
            $r = mysqli_fetch_assoc($q);

            // Check password
            if (!($password == $r['real_password'] && $email == $r['email'])) {
               $err .= "<li>Password yang dimasukkan tidak sesuai.</li>";
            } else {
               // Set session variables
               $_SESSION['name_user'] = $role == 1 ? $r['name_guru'] : ($role == 2 ? $r['name_guru'] : $r['name_siswa']);
               $_SESSION['sex'] = $r['sex'] ?? '';
               $_SESSION['bid_pendidikan'] = $r['bid_pendidikan'] ?? '';
               $_SESSION['pendidikan'] = $r['pendidikan'] ?? '';
               $_SESSION['email'] = $r['email'];
               $_SESSION['user_id'] = $r['id'];
               $_SESSION['role_id'] = $r['role_id'];
               $_SESSION['grade_class'] = $r['class'] ?? '';

               // Success message
               $roleString = $role == 1 ? 'Admin' : ($role == 2 ? 'Guru' : 'Siswa');
               $_SESSION["sukses"] = 'Selamat Anda Berhasil Login Sebagai ' . $roleString;

               $roles = $r['role_id'];

               // Redirect based on role
               // Redirect based on role
               if ($roles == 1 && $role == 1) {
                  $_SESSION['redirectlogin'] = '../../html/admin/';
                  header('Location: ../../html/admin/');
                  exit();
               } else if ($roles == 2 && $role == 2) {
                  $_SESSION['redirectlogin'] = '../../html/guru/';
                  header('Location: ../../html/guru/');
                  exit();
               } else if ($roles == 3 && $role == 3) {
                  $_SESSION['redirectlogin'] = '../../html/siswa/';
                  header('Location: ../../html/siswa/');
                  exit();
               }
               // Redirect back to login page if login failed
               header('Location: ../../html/login/login.php');
               exit();
            }
         } else {
            // Redirect back to login page if login failed
            header('Location: ../../html/login/login.php');
            exit();
         }
         // Redirect back to login page if login failed
         header('Location: ../../html/login/login.php');
         exit();
      }

      if (!empty($err)) {
         $_SESSION["error"] = $err;
      }
   }
}

// Redirect back to login page if login failed
header('Location: ../../html/login/login.php');
exit();
