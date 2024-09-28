<!DOCTYPE html>

<?php
require 'view.php';
require '../../controller/test.php';
$datasiswa = mysqli_query($koneksi, "SELECT * from tbl_siswas");
$dataguru = mysqli_query($koneksi, "SELECT * from tbl_gurus");
$datamodul = mysqli_query($koneksi, "SELECT * from tbl_moduls");
$datakelas = mysqli_query($koneksi, "SELECT * from tbl_classes");
$totalsiswa = mysqli_num_rows($datasiswa);
$totalguru = mysqli_num_rows($dataguru);
$totalmodul = mysqli_num_rows($datamodul);
$totalkelas = mysqli_num_rows($datakelas);
?>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-free">

<!-- Head -->
<?php
require './head.php';
?>
<!-- END HEAD -->

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
        require './navbar.php';
        ?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
              <div class="col-lg-3 col-md-12 col-6 mb-4">
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

                        </div>
                      </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Jumlah Guru</span>
                    <h3 class="card-title mb-2"><?= $totalguru ?></h3>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-12 col-6 mb-4">
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
                        </div>
                      </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Jumlah Siswa</span>
                    <h3 class="card-title text-nowrap mb-1"><?= $totalsiswa ?></h3>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-12 col-6 mb-4">
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
                        </div>
                      </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Jumlah Modul</span>
                    <h3 class="card-title text-nowrap mb-1"><?= $totalmodul ?></h3>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-12 col-6 mb-4">
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
                        </div>
                      </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Jumlah Kelas</span>
                    <h3 class="card-title text-nowrap mb-1"><?= $totalkelas ?></h3>
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