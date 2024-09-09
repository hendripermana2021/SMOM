<!DOCTYPE html>

<?php
session_start();
$id_test = $_GET['id_test'];
$benar = $_GET['benar'];
$salah = $_GET['salah'];
$score = $_GET['score'];
$id_student = $_GET['id_student'];

require './view.php';

$query = tampildata("SELECT * FROM tbl_test_answer_score WHERE id_test = $id_test and id_student=$id_student");

?>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<!-- Head -->
<?php require 'head.php'; ?>
<!-- END HEAD -->

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar layout-without-menu">
    <div class="layout-container">
      <!-- Layout container -->
      <div class="layout-page">
        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y mt-5">
            <!-- Left Column for displaying questions -->
            <div class="col-4" style="margin: auto;">
              <div class="card text-center">
                <div class="card-header">Result Test </div>
                <div class="card-body">
                  <h5 class="card-title">Hasil Test</h5>
                  <p class="card-text">Jumlah Skor Benar :<?= $benar ?></p>
                  <p class="card-text">Jumlah Skor Salah : <?= $salah ?></p>
                  <p class="card-text">Skor Hasil : <?= $score ?></p>
                  <a class="btn btn-primary" href="../../html/siswa/index.php">SELESAI</a>
                </div>
              </div>
            </div>
          </div>
          <!-- / Content -->


          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/vendor/js/menu.js"></script>
  <script src="../assets/js/main.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>