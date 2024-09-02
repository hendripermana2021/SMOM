<!DOCTYPE html>

<?php
session_start();
$grade = $_SESSION['grade_class'];
$user_id = $_SESSION['user_id'];
$page = "Page Test";
require 'view.php';
require '../../controller/modul.php';
$query = tampildata("SELECT * from tbl_tests where for_class='$grade' order by createdAt DESC");
$data = mysqli_query($koneksi, "SELECT * from tbl_tests where for_class='$grade'");
$testSelesai = mysqli_query($koneksi, "SELECT * from tbl_tests JOIN tbl_test_answer_score ON tbl_tests.id = tbl_test_answer_score.id_test where status_test=0 and id_student=$user_id");
$testBelumSelesai = mysqli_query($koneksi, "SELECT * from tbl_tests JOIN tbl_test_answer_score ON tbl_tests.id = tbl_test_answer_score.id_test where status_test=1 and id_student=$user_id");
$totaldata = mysqli_num_rows($data);
$totalSelesai = mysqli_num_rows($testSelesai);
$totalBelumSelesai = mysqli_num_rows($testBelumSelesai);
?>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-free">

<?php require 'head.php'; ?>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

      <?php
      require './sidebar.php';
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
              <div class="col-lg-6 col-md-4 order-1">
                <div class="row mb-4">
                  <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                          <div class="avatar flex-shrink-0">
                            <img
                              src="../../assets/img/icons/unicons/chart-success.png"
                              alt="chart success"
                              class="rounded" />
                          </div>
                          <div class="dropdown">
                            <button
                              class="btn p-0"
                              type="button"
                              id="cardOpt3"
                              data-bs-toggle="dropdown"
                              aria-haspopup="true"
                              aria-expanded="false">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                              <a class="dropdown-item" href="javascript:void(0);">View More</a>
                              <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                          </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Soal Belum Selesai</span>
                        <h3 class="card-title mb-2"><?= $totalBelumSelesai ?></h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> Test</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                          <div class="avatar flex-shrink-0">
                            <img
                              src="../../assets/img/icons/unicons/wallet-info.png"
                              alt="Credit Card"
                              class="rounded" />
                          </div>
                          <div class="dropdown">
                            <button
                              class="btn p-0"
                              type="button"
                              id="cardOpt6"
                              data-bs-toggle="dropdown"
                              aria-haspopup="true"
                              aria-expanded="false">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                              <a class="dropdown-item" href="javascript:void(0);">View More</a>
                              <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                          </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Soal Selesai</span>
                        <h3 class="card-title text-nowrap mb-1"><?= $totalSelesai ?></h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> Test</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="card" style="padding:20px">
                <h5 class="card-header p-0 pb-3">Table Test</h5>
                <div class="table-responsive text-wrap">
                  <div class="col-lg-12 col-md-6">
                    <div class="row mb-2">
                      <?php
                      // Retrieve data about unfinished tests
                      $checkTestBelumSelesai = tampildata("SELECT tbl_test_answer_score.id as id_answer, tbl_test_answer_score.status_test as status, tbl_test_answer_score.id_student as id_student, tbl_test_answer_score.id_test as id_test FROM tbl_tests JOIN tbl_test_answer_score ON tbl_tests.id = tbl_test_answer_score.id_test WHERE status_test = 0 AND id_student = $user_id ORDER BY createdAt DESC");
                      $testIds = array_column($checkTestBelumSelesai, 'id_test');
                      $i = 0;

                      foreach ($query as $row) :
                        $testIdFromRow = $row['id'];

                        if (in_array($testIdFromRow, $testIds)) {
                          $buttonStart = '<span class="btn btn-success">Selesai</span>';
                        } else {
                          $buttonStart = '<a href="confirmTest?id=' . $row['id'] . '" class="btn btn-outline-primary">Start Test</a>';
                        }
                      ?>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-3">
                          <div class="card h-100">
                            <div class="card-body">
                              <h5 class="card-title"><?= $row['title'] ?></h5>
                              <p class="card-text">
                                <?= $row['description'] ?>
                              </p>
                              <?= $buttonStart ?>
                            </div>
                          </div>
                        </div>
                      <?php $i++;
                      endforeach; ?>
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