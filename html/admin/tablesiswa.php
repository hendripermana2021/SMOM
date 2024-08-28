<!DOCTYPE html>
<?php
$page = "Page Siswa";
require 'view.php';
require '../../controller/siswa.php';
$query = tampildata("SELECT s.name_siswa, s.sex, s.fathername, s.mothername,s.status, s.id_class, s.email, s.real_password, s.image, s.id as id_siswa, k.* FROM tbl_siswas s JOIN tbl_classes k ON s.id_class = k.id");
$data = mysqli_query($koneksi, "SELECT s.*, k.* FROM tbl_siswas s JOIN tbl_classes k ON s.id_class = k.id");
$totaldata = mysqli_num_rows($data);
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
                      <li class="breadcrumb-item"><?= $page ?></li>
                      <li class="breadcrumb-item active">Tabel Siswa</li>
                    </ol>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <div class="text-end mb-4">
                      <button
                        type="button"
                        class="btn btn-primary pb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#add">
                        Tambah Siswa
                      </button>
                    </div>
                  </div>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover" id="basic-1">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>JK.</th>
                        <th>Nama Ayah</th>
                        <th>Nama Ibu</th>
                        <th>Status</th>
                        <th>Kelas</th>
                        <th>Password</th>
                        <th class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php
                      $index = 1; // Initialize the index variable
                      foreach ($query as $row) :
                      ?>
                        <tr>
                          <?php
                          $JK = $row['sex'];
                          if ($JK == 'L') {
                            $JenisKelamin = '<span class="badge bg-label-primary">Laki-laki</span>';
                          } else {
                            $JenisKelamin = '<span class="badge bg-label-danger">Perempuan</span>';
                          }
                          ?>

                          <?php
                          $statusSiswa = $row['status'];
                          if ($statusSiswa == 'Active') {
                            $status = '<span class="badge bg-label-success">Active</span>';
                          } else {
                            $status = '<span class="badge bg-label-danger">Non-Active</span>';
                          }
                          ?>

                          <td><?= $index++ ?></td> <!-- Output the index and increment it -->
                          <td><?= $row['name_siswa'] ?></td>
                          <td><?= $JenisKelamin ?></td>
                          <td><?= $row['fathername'] ?></td>
                          <td><?= $row['mothername'] ?></td>
                          <td><?= $status ?></td>
                          <td><?= $row['name_class'] ?></td>
                          <td><?= $row['real_password'] ?></td>
                          <td class="text-center col-2">
                            <button
                              type="button"
                              class="btn btn-warning"
                              data-bs-toggle="modal"
                              data-bs-target="#ubah<?= $row['id_siswa'] ?>">
                              Edit
                            </button>
                            <button
                              type="button"
                              class="btn btn-danger"
                              data-bs-toggle="modal"
                              data-bs-target="#delete<?= $row['id_siswa'] ?>">
                              Delete
                            </button>
                          </td>
                        </tr>

                        <!-- Modal Update -->
                        <div class="modal fade" id="ubah<?= $row['id_siswa'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Update Data Siswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action=""> <!-- pastikan action mengarah ke file PHP yang menangani update -->
                                <input type="hidden" name="control" value="update">
                                <input type="hidden" name="id_siswa" value="<?= $row['id_siswa'] ?>">
                                <div class="modal-body">
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Name Siswa</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" name="name_siswa" value="<?= $row['name_siswa'] ?>" required />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Sex</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <select class="form-select" name="sex" required>
                                          <option hidden>Pilih Gender</option>
                                          <option value="L" <?= $row['sex'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                          <option value="P" <?= $row['sex'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Kelas</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <select class="form-select" name="kelas" required>
                                          <option hidden>Pilih Kelas</option>
                                          <?php
                                          $kelas = tampildata("SELECT * FROM tbl_classes");
                                          foreach ($kelas as $option) : ?>
                                            <option value="<?= $option['id'] ?>" <?= $option['id'] == $row['id_class'] ? 'selected' : '' ?>>
                                              <?= $option['name_class'] ?>
                                            </option>
                                          <?php endforeach; ?>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Nama Ayah</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" name="namaayah" value="<?= $row['fathername'] ?>" required />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Name Ibu</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" name="namaibu" value="<?= $row['mothername'] ?>" required />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <select class="form-select" name="status" required>
                                          <option hidden>Pilih Status</option>
                                          <option value="Active" <?= $row['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                                          <option value="UnActive" <?= $row['status'] == 'UnActive' ? 'selected' : '' ?>>Non-Active</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" name="email" value="<?= $row['email'] ?>" required />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-key"></i></span>
                                        <input type="password" class="form-control" name="password" value="<?= $row['real_password'] ?>" required />
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" name="prosessiswa" class="btn btn-primary">Save changes</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <!-- Modal Delete -->
                        <div class="modal fade" id="delete<?= $row['id_siswa'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Delete Data Siswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action=""> <!-- pastikan action mengarah ke file PHP yang menangani delete -->
                                <input type="hidden" name="id_siswa" value="<?= $row['id_siswa'] ?>">
                                <input type="hidden" name="control" value="delete">
                                <div class="modal-body">
                                  <p>Apakah anda ingin menghapus data Siswa <span class="badge bg-label-danger"><?= $row['name_siswa'] ?></span> ?</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" name="prosessiswa" class="btn btn-danger">Delete</button>
                                </div>
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
            <h5 class="modal-title">Tambah Data Siswa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action=""> <!-- pastikan action mengarah ke file PHP yang menangani update -->
            <input type="hidden" name="control" value="add">
            <div class="modal-body">
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Name Siswa</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                    <input type="text" class="form-control" name="name_siswa" required />
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Sex</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                    <select class="form-select" name="sex" required>
                      <option hidden>Pilih Gender</option>
                      <option value="L">Laki-laki</option>
                      <option value="P">Perempuan</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Kelas</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                    <select class="form-select" name="kelas" required>
                      <option hidden>Pilih Kelas</option>
                      <?php
                      $kelas = tampildata("SELECT * FROM tbl_classes");
                      foreach ($kelas as $option) : ?>
                        <option value="<?= $option['id'] ?>"><?= $option['name_class'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Nama Ayah</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                    <input type="text" class="form-control" name="namaayah" required />
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Name Ibu</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                    <input type="text" class="form-control" name="namaibu" required />
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                    <select class="form-select" name="status" required>
                      <option hidden>Pilih Status</option>
                      <option value="Active">Active</option>
                      <option value="UnActive">Non-Active</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                    <input type="text" class="form-control" name="email" required />
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-key"></i></span>
                    <input type="password" class="form-control" name="password" required />
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="prosessiswa" class="btn btn-primary">Save</button>
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
  <!-- Page JS -->
  <script src="../../assets/js/dashboards-analytics.js"></script>
  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>