<!DOCTYPE html>

<?php
$id_test = $_GET['id'];

require './view.php';
require '../../controller/siswa.php';

$query = tampildata("SELECT * from tbl_tests where id = $id_test");
$data = mysqli_query($koneksi, "SELECT * from tbl_tests where id = $id_test");
$totaldata = mysqli_num_rows($data);
?>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<!-- Head -->
<?php require './head.php'; ?>
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
            <div class="col-4" style="margin: auto; ">
              <div class="card text-center">
                <form action="">
                  <?php
                  $index = 1; // Initialize the index variable
                  foreach ($query as $row) : ?>
                    <div class="card-header">Confirmation Form for Doing Test</div>
                    <div class="card-body">
                      <h5 class="card-title"><?= $row['title'] ?></h5>
                      <p class="card-text"><?= $row['description'] ?></p>
                      <p class="card-text">Jumlah Skor Benar <?= $row['totalscore'] ?></p>
                      <a href="viewTest.php?id=" class="btn btn-primary">Start Test</a>
                    </div>
                    <div class="card-footer text-muted">Don't click start if you not ready!</div>
                  <?php endforeach; ?>
                </form>
              </div>
            </div>

          </div>
          <!-- / Content -->

          <!-- Footer -->
          <?php require './footer.php'; ?>
          <!-- / Footer -->

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