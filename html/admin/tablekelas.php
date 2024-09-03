<!DOCTYPE html>
<?php
$page = "Page Kelas";
require 'view.php';
require '../../controller/kelas.php';
$query = tampildata("SELECT 
    c.id AS id_kelas, 
    c.id_walkes, 
    c.grade_class, 
    c.name_class, 
    g.*
FROM 
    tbl_classes c 
LEFT JOIN 
    tbl_gurus g 
ON 
    c.id_walkes = g.id;");
?>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template-free">

<!-- Head -->
<?php require './head.php'; ?>
<!-- END HEAD -->

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
                  <h3><?= $page ?></h3>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="card" style="padding:20px">
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="index"> <i data-feather="home"></i></a></li>
                      <li class="breadcrumb-item">Admin</li>
                      <li class="breadcrumb-item"><?= htmlspecialchars($page) ?></li>
                      <li class="breadcrumb-item active">Tabel Kelas</li>
                    </ol>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <div class="text-end mb-4">
                      <button
                        type="button"
                        class="btn btn-primary pb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#add">
                        Tambah Kelas
                      </button>
                    </div>
                  </div>

                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover" id="basic-1">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Name Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Tingkat Kelas</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php
                      $index = 1;
                      foreach ($query as $row) :
                      ?>
                        <tr>
                          <td><?= $index++ ?></td>
                          <td><?= htmlspecialchars($row['name_class']) ?></td>
                          <td><?= htmlspecialchars($row['name_guru']) ?></td>
                          <td><?= htmlspecialchars($row['grade_class']) ?></td>
                          <td class="text-center col-2">
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ubah<?= $row['id_kelas'] ?>">
                              Edit
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $row['id_kelas'] ?>">
                              Delete
                            </button>
                          </td>
                        </tr>

                        <!-- Modal Update -->
                        <div class="modal fade" id="ubah<?= $row['id_kelas'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Update Data Kelas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action="">
                                <input type="hidden" name="control" value="update">
                                <div class="modal-body">
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Name Kelas</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" name="name_kelas" value="<?= htmlspecialchars($row['name_class']) ?>" required />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Tingkat Kelas</label>
                                    <div class="col-sm-10">
                                      <select class="form-select" name="tingkat" required>
                                        <option selected hidden>Pilih Tingkat</option>
                                        <option value="X" <?= $row['grade_class'] == 'X' ? 'selected' : '' ?>>X</option>
                                        <option value="XI" <?= $row['grade_class'] == 'XI' ? 'selected' : '' ?>>XI</option>
                                        <option value="XII" <?= $row['grade_class'] == 'XII' ? 'selected' : '' ?>>XII</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Wali Kelas</label>
                                    <div class="col-sm-10">
                                      <select class="form-select" name="walkes" required>
                                        <option selected hidden>Pilih Wali Kelas</option>
                                        <?php
                                        $walikelas = tampildata("SELECT * FROM tbl_gurus where role_id=2");
                                        foreach ($walikelas as $option) : ?>
                                          <option value="<?= $option['id'] ?>" <?= $row['id_walkes'] == $option['id'] ? 'selected' : '' ?>>
                                            <?= $option['name_guru'] ?>
                                          </option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" name="proseskelas" class="btn btn-primary">Save changes</button>
                                </div>
                                <input type="hidden" name="id_class" value="<?= htmlspecialchars($row['id_kelas']) ?>" />
                              </form>
                            </div>
                          </div>
                        </div>

                        <!-- Modal Delete -->
                        <div class="modal fade" id="delete<?= $row['id_kelas'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Delete Data Kelas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action="">
                                <input type="hidden" name="control" value="delete">
                                <div class="modal-body">
                                  <p>Apakah anda ingin menghapus data kelas <span class="badge bg-label-danger"><?= $row['name_class'] ?></span>?</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" name="proseskelas" class="btn btn-danger">Delete</button>
                                </div>
                                <input type="hidden" name="id_class" value="<?= htmlspecialchars($row['id_kelas']) ?>" />
                              </form>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
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
    <!-- Modal Update -->
    <div class="modal fade" id="add" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Update Data Kelas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="">
            <input type="hidden" name="control" value="add">
            <div class="modal-body">
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Name Kelas</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                    <input type="text" class="form-control" name="name_kelas" required />
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Tingkat Kelas</label>
                <div class="col-sm-10">
                  <select class="form-select" name="tingkat" required>
                    <option selected hidden>Pilih Tingkat</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                  </select>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Wali Kelas</label>
                <div class="col-sm-10">
                  <select class="form-select" name="walkes" required>
                    <option selected hidden>Pilih Wali Kelas</option>
                    <?php
                    $walikelas = tampildata("SELECT * FROM tbl_gurus where role_id=2");
                    foreach ($walikelas as $option) : ?>
                      <option value="<?= $option['id'] ?>">
                        <?= $option['name_guru'] ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="proseskelas" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- jQuery (required for DataTables) -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

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
</body>

</html>