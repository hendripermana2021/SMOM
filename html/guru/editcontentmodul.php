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
<script src="https://cdn.jsdelivr.net/npm/quill-table-ui@0.3.0/dist/quill-table-ui.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill-table-ui@0.3.0/dist/quill-table-ui.min.css">
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
              <div class="card" style="padding:20px">
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="index"> <i data-feather="home"></i></a></li>
                      <li class="breadcrumb-item">Modul</li>
                      <li class="breadcrumb-item"><?= htmlspecialchars($page) ?></li>
                      <li class="breadcrumb-item active">Update Content</li>
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
                    <form method="POST" id="update-content<?= $row['id'] ?>" action="../../controller/guru/updatecontentmodul.php">
                      <input type="hidden" name="control" value="update">
                      <input type="hidden" name="content" id="content<?= $row['id'] ?>">
                      <input type="hidden" name="id_content" value="<?= $row['id'] ?>">
                      <input type="hidden" name="id_modul" value="<?= $id_modul ?>">
                      <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                        <div class="row mb-3">
                          <label class="col-sm-1 col-form-label">Section</label>
                          <div class="col-sm-11">
                            <div class="input-group input-group-merge">
                              <span class="input-group-text"><i class="bx bx-book"></i></span>
                              <input type="text" class="form-control" name="section" id="update-section<?= $row['id'] ?>" value="<?= $row['section'] ?>" required />
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-1 col-form-label">Position</label>
                          <div class="col-sm-2">
                            <select name="position" id="position" class="form-select" required>
                              <script>
                                for (let i = 1; i <= 30; i++) {
                                  const selected = (<?= $row['position'] ?> == i) ? 'selected' : '';
                                  document.write(`<option value="${i}" ${selected}>${i}</option>`);
                                }
                              </script>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label">Content</label>
                          <div class="col-lg-12 col-md-12">
                            <div id="toolbar-container-update<?= $row['id'] ?>">
                              <!-- Quill Toolbar Buttons Here -->
                              <span class="ql-formats">
                                <select class="ql-font"></select>
                                <select class="ql-size"></select>
                              </span>
                              <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                              </span>
                              <span class="ql-formats">
                                <select class="ql-color"></select>
                                <select class="ql-background"></select>
                              </span>
                              <span class="ql-formats">
                                <button class="ql-script" value="sub"></button>
                                <button class="ql-script" value="super"></button>
                              </span>
                              <span class="ql-formats">
                                <button class="ql-header" value="1"></button>
                                <button class="ql-header" value="2"></button>
                                <button class="ql-blockquote"></button>
                                <button class="ql-code-block"></button>
                              </span>
                              <span class="ql-formats">
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                                <button class="ql-indent" value="-1"></button>
                                <button class="ql-indent" value="+1"></button>
                              </span>
                              <span class="ql-formats">
                                <button class="ql-direction" value="rtl"></button>
                                <select class="ql-align"></select>
                              </span>
                              <span class="ql-formats">
                                <button class="ql-link"></button>
                                <button class="ql-image"></button>
                                <button class="ql-video"></button>
                                <button class="ql-formula"></button>
                              </span>
                              <span class="ql-formats">
                                <button class="ql-clean"></button>
                              </span>
                              <span class="ql-formats">
                                <button class="ql-table"></button> <!-- Added table button -->
                              </span>
                            </div>

                            <div id="editor-update<?= $row['id'] ?>" style="height: 1000px;">
                              <?= $row['content'] ?>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" name="prosesmodul" class="btn btn-primary">Save changes</button>
                      </div>
                    </form>




                    <script>
                      const quillUpdate<?= $row['id'] ?> = new Quill('#editor-update<?= $row['id'] ?>', {
                        modules: {
                          syntax: true,
                          toolbar: '#toolbar-container-update<?= $row['id'] ?>',
                          table: true, // Enable the table module
                        },
                        placeholder: 'Compose an epic...',
                        theme: 'snow',
                      });

                      document.querySelector('#update-content<?= $row['id'] ?>').onsubmit = function() {
                        document.querySelector('#content<?= $row['id'] ?>').value = quillUpdate<?= $row['id'] ?>.root.innerHTML;
                      };
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