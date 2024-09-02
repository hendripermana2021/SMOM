<!DOCTYPE html>

<?php
session_start();
$user_id = $_SESSION['user_id'];
$id_test = $_GET['id_test'];
require 'view.php';
require '../../controller/test.php';
$query = tampildata("SELECT * from tbl_test_answer_score JOIN tbl_siswas ON tbl_test_answer_score.id_student = tbl_siswas.id where id_test=$id_test");

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
              <div class="col-lg-12 col-md-12 col-6 mb-4">
                <div class="card">
                  <div class="card-body">
                    <div class="card-title">Peserta Didik</div>
                    <div class="table-responsive text-nowrap">
                      <table class="table table-hover" id="basic-1">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Score</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                          <?php
                          $index = 1; // Initialize the index variable
                          foreach ($query as $row) :
                          ?>

                            <?php
                            if ($row['status_test'] == 0) {
                              $status = 'Selesai';
                              $styleClass = 'badge bg-success';
                            } else {
                              $status = 'Belum Selesai';
                              $styleClass = 'badge bg-danger';
                            }

                            ?>
                            <tr>
                              <td><?= $index++ ?></td> <!-- Output the index and increment it -->
                              <td><?= $row['name_siswa'] ?></td>
                              <td><?= $row['score'] ?></td>
                              <td><span class="<?= $styleClass ?>"><?= $status ?></span></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
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