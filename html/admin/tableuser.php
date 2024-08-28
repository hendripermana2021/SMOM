<!DOCTYPE html>
<?php
$page = "Page User";
require 'view.php';
require '../../controller/user.php';
$query = tampildata("SELECT * FROM tbl_gurus where role_id=1 order by createdAt DESC");
$data = mysqli_query($koneksi, "SELECT * FROM tbl_gurus where role_id=1");
$totaldata = mysqli_num_rows($data);
?>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-free">

<!-- Head -->
<?php require './head.php'; ?>
<!-- END HEAD -->

<body onload="startTime()">
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <?php require 'sidebar.php'; ?>
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
                    <ol class="breadcrumb text-end">
                      <li class="breadcrumb-item"><a href="index"> <i data-feather="home"></i></a></li>
                      <li class="breadcrumb-item">Admin</li>
                      <li class="breadcrumb-item"><?= $page ?></li>
                      <li class="breadcrumb-item active">Tabel User</li>
                    </ol>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <div class="text-end mb-4">
                      <button
                        type="button"
                        class="btn btn-primary pb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#add">
                        Tambah User
                      </button>
                    </div>
                  </div>
                </div>
                <div class="table-responsive text-nowrap">

                  <table class="table table-hover" id="basic-1">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>JK.</th>
                        <th>Pendidikan</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Actions</th>
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

                          <td><?= $index++ ?></td> <!-- Output the index and increment it -->
                          <td><?= $row['name_guru'] ?></td>
                          <td><?= $JenisKelamin ?></td> <!-- Use $JenisKelamin instead of $JK -->
                          <td><?= $row['pendidikan'] ?></td>
                          <td><?= $row['email'] ?></td>
                          <td><?= $row['real_password'] ?></td>
                          <td><span class="badge bg-label-warning">Admin</span></td>
                          <td class="text-center col-2">
                            <button
                              type="button"
                              class="btn btn-warning"
                              data-bs-toggle="modal"
                              data-bs-target="#ubah<?= $row['id'] ?>">
                              Edit
                            </button>
                            <button
                              type="button"
                              class="btn btn-danger"
                              data-bs-toggle="modal"
                              data-bs-target="#delete<?= $row['id'] ?>">
                              Delete
                            </button>
                          </td>
                        </tr>

                        <!-- Modal Update -->
                        <div class="modal fade" id="ubah<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Update Data User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action=""> <!-- pastikan action mengarah ke file PHP yang menangani update -->
                                <input type="hidden" name="control" value="update">
                                <input type="hidden" name="id_user" value="<?= $row['id'] ?>">
                                <div class="modal-body">
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Name User</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" name="name_user" value="<?= $row['name_guru'] ?>" required />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Pendidikan</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <select class="form-select" name="pendidikan" required>
                                          <option hidden>Pilih Pendidikan</option>
                                          <option value="SMA/SMK" <?= $row['pendidikan'] == 'SMA/SMK' ? 'selected' : '' ?>>SMA/SMK</option>
                                          <option value="S1" <?= $row['pendidikan'] == 'S1' ? 'selected' : '' ?>>S1</option>
                                          <option value="S2" <?= $row['pendidikan'] == 'S2' ? 'selected' : '' ?>>S2</option>
                                          <option value="S3" <?= $row['pendidikan'] == 'S3' ? 'selected' : '' ?>>S3</option>
                                        </select>
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
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                        <input type="email" class="form-control" name="email" value="<?= $row['email'] ?>" required />
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
                                  <button type="submit" name="prosesuser" class="btn btn-primary">Save changes</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <!-- Modal Delete -->
                        <div class="modal fade" id="delete<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Delete Data Guru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action="">
                                <input type="hidden" name="control" value="delete">
                                <div class="modal-body">
                                  <p>Apakah anda ingin menghapus data bapak/ibu <span class="badge bg-label-danger"><?= $row['name_guru'] ?></span> ?</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" name="prosesuser" class="btn btn-danger">Delete</button>
                                </div>
                                <input type="hidden" name="id_user" value="<?= $row['id'] ?>" />
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
          <!-- Modal Add -->
          <div class="modal fade" id="add" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Tambah Data User</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action=""> <!-- Ensure the action points to the correct PHP file for handling insertion -->
                  <input type="hidden" name="control" value="add">
                  <div class="modal-body">
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Nama User</label>
                      <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                          <span class="input-group-text"><i class="bx bx-user"></i></span>
                          <input type="text" class="form-control" name="name_user" placeholder="Enter Name User" required />
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Pendidikan</label>
                      <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                          <span class="input-group-text"><i class="bx bx-book"></i></span>
                          <select class="form-select" name="pendidikan" required>
                            <option hidden>Pilih Pendidikan</option>
                            <option value="SMA/SMK">SMA/SMK</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Sex</label>
                      <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                          <span class="input-group-text"><i class="bx bx-male-female"></i></span>
                          <select class="form-select" name="sex" required>
                            <option hidden>Pilih Gender</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                          <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                          <input type="email" class="form-control" name="email" placeholder="Enter Email" required />
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label class="col-sm-2 col-form-label">Password</label>
                      <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                          <span class="input-group-text"><i class="bx bx-key"></i></span>
                          <input type="password" class="form-control" name="password" placeholder="Enter Password" required />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="prosesuser" class="btn btn-primary">Tambah</button>
                  </div>
                </form>
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

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- jQuery (required for DataTables) -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

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