<!DOCTYPE html>

<?php
session_start();
require 'view.php';
require '../../controller/test.php';
$user_id = $_SESSION['user_id'];
$dataSiswa = mysqli_query($koneksi, "SELECT * from tbl_classes JOIN tbl_siswas ON tbl_classes.id = tbl_siswas.id_class where id_walkes=$user_id ");
$dataSiswaActive = mysqli_query($koneksi, "SELECT * from tbl_classes JOIN tbl_siswas ON tbl_classes.id = tbl_siswas.id_class where id_walkes=$user_id and status='Active' ");
$dataSiswaUnActive = mysqli_query($koneksi, "SELECT * from tbl_classes JOIN tbl_siswas ON tbl_classes.id = tbl_siswas.id_class where id_walkes=$user_id and status='UnActive' ");
$dataGuru = mysqli_query($koneksi, "SELECT * from tbl_gurus");
$dataModul = mysqli_query($koneksi, "SELECT * from tbl_moduls");
$dataKelas = mysqli_query($koneksi, "SELECT * from tbl_classes where id_walkes=$user_id");
$totalsiswa = mysqli_num_rows($dataSiswa);
$totalguru = mysqli_num_rows($dataGuru);
$totalmodul = mysqli_num_rows($dataModul);
$totalkelas = mysqli_num_rows($dataKelas);
$totalSiswaActive = mysqli_num_rows($dataSiswaActive);
$totalSiswaUnActive = mysqli_num_rows($dataSiswaUnActive);
?>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-free">

<?php require 'head.php'; ?>
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
        require '../admin/navbar.php';
        ?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
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
                        </div>
                      </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Peserta Didik</span>
                    <h3 class="card-title mb-2"><?= $totalsiswa ?></h3>
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
            <div class="row">
              <div class="col-lg-12 col-md-12 col-6 mb-4">
                <div class="card">
                  <div class="card-body">
                    <div class="card-title">Peserta Didik</div>
                    <div class="row">
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
                                </div>
                              </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Siswa Aktif</span>
                            <h3 class="card-title text-nowrap mb-1"><?= $totalSiswaActive ?></h3>
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
                                </div>
                              </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Siswa Tidak Aktif</span>
                            <h3 class="card-title text-nowrap mb-1"><?= $totalSiswaUnActive ?></h3>
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
          require '../admin/footer.php';
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