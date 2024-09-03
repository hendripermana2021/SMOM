<!DOCTYPE html>

<?php
session_start();
require 'view.php';
$user_id = $_SESSION['user_id'];
$class = $_SESSION['grade_class'];
$dataModal = mysqli_query($koneksi, "SELECT * FROM tbl_moduls where for_class='$class'");
$testSelesai = mysqli_query($koneksi, "SELECT * from tbl_tests JOIN tbl_test_answer_score ON tbl_tests.id = tbl_test_answer_score.id_test where status_test=0 and id_student=$user_id");
$testBelumSelesai = mysqli_query($koneksi, "SELECT * from tbl_tests JOIN tbl_test_answer_score ON tbl_tests.id = tbl_test_answer_score.id_test where status_test=1 and id_student=$user_id");
$totalModal = mysqli_num_rows($dataModal);
$totalTestSelesai = mysqli_num_rows($testSelesai);
$totalTestBelumSelesai = mysqli_num_rows($testBelumSelesai);
?>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-free">

<!-- Head -->
<?php require 'head.php'; ?>
<!-- END HEAD -->

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

      <?php
      require 'sidebar.php';
      ?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        <?php
        require 'navbar.php';
        ?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
              <div class="col-lg-3 col-md-4 order-0">
                <div class="card">
                  <div class="d-flex align-items-end row">
                    <div class="col-lg-12 col-md-6">
                      <div class="card-body">
                        <h5 class="card-title text-primary">You have Moduls from your teacher</h5>
                        <h3 class="card-title mb-4"><?= $totalModal ?> <span class="badge bg-label-primary" style="font-size:small;">Module</span></h3>
                        <a href="viewModulSiswa.php" class="btn btn-sm btn-outline-primary">Read Now</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-9 col-md-4 order-0">
                <div class="card p-4">
                  <div class="card-title"><span class="badge bg-label-success" style="font-size:small;">Test Online</span></h3>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 col-md-6">
                      <div class="card">
                        <div class="d-flex align-items-end row">
                          <div class="col-lg-12 col-md-6">
                            <div class="card-body">
                              <h5 class="card-title text-primary">Test Sudah Selesai</h5>
                              <h3 class="card-title mb-4"><?= $totalTestSelesai ?> <span class="badge bg-label-primary" style="font-size:small;">Test</span></h3>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                      <div class="card">
                        <div class="d-flex align-items-end row">
                          <div class="col-lg-12 col-md-6">
                            <div class="card-body">
                              <h5 class="card-title text-primary">Test Belum Selesai</h5>
                              <h3 class="card-title mb-4"><?= $totalTestBelumSelesai ?> <span class="badge bg-label-primary" style="font-size:small;">Test</span></h3>
                              <?php
                              if ($totalTestBelumSelesai > 0) {
                                $buttonTest = ' <a href="javascript:;" class="btn btn-sm btn-outline-primary">Kerjakan</a>';
                              } else {
                                $buttonTest = '';
                              }
                              ?>
                              <?= $buttonTest ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <!-- / Content -->

          <!-- Footer -->
          <?php
          require './footer.php';
          ?>
          <!-- / Footer -->

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->



  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../../assets/vendor/libs/popper/popper.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>
  <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="../../assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>

  <!-- Main JS -->
  <script src="../../assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="../../assets/js/dashboards-analytics.js"></script>

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>