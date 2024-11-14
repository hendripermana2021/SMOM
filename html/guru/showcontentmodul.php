<!DOCTYPE html>
<?php
$page = "Page Showing Content";
require 'view.php';

// Securely retrieve the id and prevent SQL injection
$id = intval($_GET['id_content']);
$id_modul = intval($_GET['id']);
$query = tampildata("SELECT * FROM tbl_modul_contents WHERE id=$id ");
?>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template-free">

<!-- Head -->
<?php require './head.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
<!-- END HEAD -->

<style>
  .dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0;
  }
</style>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <?php require 'sidebar.php'; ?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        <?php require 'navbar.php'; ?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h3><?= htmlspecialchars($page) ?></h3>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="card" style="padding:20px; padding-bottom:70px">
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="index"> <i data-feather="home"></i></a></li>
                      <li class="breadcrumb-item">Modul</li>
                      <li class="breadcrumb-item"><?= htmlspecialchars($page) ?></li>
                      <li class="breadcrumb-item active">Show Content</li>
                    </ol>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <div class="text-end mb-4">
                      <a href="./tablemodul-detail.php?id=<?= $id_modul ?>" class="btn btn-info" role="button">Kembali</a>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <?php foreach ($query as $row) : ?>
                    <div class="show-content">
                      <div class="col-sm-12">
                        <p><?= htmlspecialchars($row['section']) ?></p>
                      </div>
                      <div class="col-lg-12 col-md-12 " id="editor-show<?= $row['id'] ?>">
                        <?= $row['content'] ?>
                      </div>
                    </div>

                    <script>
                      const quillShow<?= $row['id'] ?> = new Quill('#editor-show<?= $row['id'] ?>', {
                        modules: {
                          syntax: true,
                          table: true, // Enable the table module,
                          toolbar: false
                        },
                        placeholder: 'Compose an epic...',
                        theme: 'snow',
                      });
                    </script>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <?php require 'footer.php'; ?>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- Initialize DataTable -->
    <script>
      $(document).ready(function() {
        $('#basic-1').DataTable();
      });
    </script>

    <!-- Core JS -->
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/js/menu.js"></script>
    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>
    <!-- Page JS -->
    <script src="../../assets/js/dashboards-analytics.js"></script>
    <!-- GitHub Buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- Initialize Quill -->
    <script>
      const quill = new Quill('#editor', {
        modules: {
          syntax: true,
          toolbar: '#toolbar-container',
        },
        placeholder: 'Compose an epic...',
        theme: 'snow',
      });

      // Update content field with editor data
      document.querySelector('#show-content').value = quill.root.innerHTML;
    </script>
</body>

</html>