<!DOCTYPE html>

<?php
session_start();
$id_test = $_GET['id'];
$id_student = $_SESSION['user_id'];

require './view.php';
require '../../controller/siswa/confirm-test.php';

$query = tampildata("SELECT * FROM tbl_tests WHERE id = $id_test");
$data = mysqli_query($koneksi, "SELECT * FROM tbl_tests WHERE id = $id_test");
$totaldata = mysqli_num_rows($data);
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
            <div class="col-xl-3 col-lg-5 col-md-5 col-sm-7" style="margin: auto;">
              <div class="card text-center">
                <form action="" method="post">
                  <input type="hidden" name="id_test" value="<?= $id_test ?>">
                  <input type="hidden" name="id_student" value="<?= $id_student ?>">
                  <input type="hidden" name="control" value="add">
                  <?php foreach ($query as $row) : ?>
                    <div class="card-header">Confirmation Form for Doing Test </div>
                    <div class="card-body">
                      <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                      <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>
                      <p class="card-text">Jumlah Skor Benar: <?= htmlspecialchars($row['totalscore']) ?></p>
                      <button class="btn btn-primary" type="submit" name="confirm">Start Test</button>
                    </div>
                    <div class="card-footer text-muted">Don't click start if you're not ready!</div>
                  <?php endforeach; ?>
                </form>
              </div>
            </div>
          </div>

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