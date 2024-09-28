<!DOCTYPE html>
<?php
session_start();
$page = "Page Test";
require 'view.php';
require '../../controller/test.php';
$id_user = $_SESSION['user_id'];
$query = tampildata("SELECT * from tbl_tests where id_users=$id_user");
$data = mysqli_query($koneksi, "SELECT * from tbl_tests where id_users=$id_user");
$totaldata = mysqli_num_rows($data);
?>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template-free">

<!-- Head -->
<?php require 'head.php'; ?>
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
                      <li class="breadcrumb-item">Guru</li>
                      <li class="breadcrumb-item"><?= $page ?></li>
                      <li class="breadcrumb-item active">Test</li>
                    </ol>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <div class="text-end mb-4">
                      <button
                        type="button"
                        class="btn btn-primary pb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#add">
                        Tambah Test
                      </button>
                    </div>
                  </div>
                </div>
                <h5 class="card-header p-0 pb-3">Table Test</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover" id="basic-1">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Judul Test</th>
                        <th>Deskripsi</th>
                        <th>Skor</th>
                        <th>Assignment For</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php
                      $index = 1; // Initialize the index variable
                      foreach ($query as $row) :
                      ?>
                        <tr>
                          <td><?= $index++ ?></td> <!-- Output the index and increment it -->
                          <td><?= $row['title'] ?></td>
                          <td><?= $row['description'] ?></td>
                          <td><?= $row['totalscore'] ?></td>
                          <td><?= $row['for_class'] ?></td>
                          <td class="text-center col-2">
                            <div class="btn-group">
                              <button
                                type="button"
                                class="btn btn-outline-primary dropdown-toggle"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Actions
                              </button>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="test-question.php?id=<?= htmlspecialchars($row['id']) ?>">Add Question</a></li>
                                <li><a class="dropdown-item" href="viewResultTest.php?id_test=<?= htmlspecialchars($row['id']) ?>"> Lihat Hasil</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ubah<?= $row['id'] ?>">Edit Test</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete<?= $row['id'] ?>">Delete Test</a></li>
                              </ul>
                            </div>
                          </td>
                        </tr>

                        <!-- Modal Update -->
                        <div class="modal fade" id="ubah<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Update Data Test</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action=""> <!-- Ensure the action points to the PHP file handling the update -->
                                <input type="hidden" name="id_test" value="<?= $row['id'] ?>">
                                <input type="hidden" name="control" value="update">
                                <div class="modal-body">
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Judul Test</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" name="title" value="<?= $row['title'] ?>" required />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-info-circle"></i></span>
                                        <textarea class="form-control" name="description" required><?= $row['description'] ?></textarea>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Total Score</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-calculator"></i></span>
                                        <input type="number" class="form-control" name="totalscore" value="<?= $row['totalscore'] ?>" min="0" max="100" maxlength="3" required />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Class</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-school"></i></span>
                                        <select class="form-select" name="tingkat" required>
                                          <option selected hidden>Pilih Tingkat</option>
                                          <option value="X" <?= $row['for_class'] == 'X' ? 'selected' : '' ?>>X</option>
                                          <option value="XI" <?= $row['for_class'] == 'XI' ? 'selected' : '' ?>>XI</option>
                                          <option value="XII" <?= $row['for_class'] == 'XII' ? 'selected' : '' ?>>XII</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" name="prosestest" class="btn btn-primary">Save changes</button>
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
                                <h5 class="modal-title">Delete Data Test</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action=""> <!-- Ensure the action points to the PHP file handling the delete -->
                                <input type="hidden" name="id_test" value="<?= $row['id'] ?>" />
                                <input type="hidden" name="control" value="delete" />
                                <div class="modal-body">
                                  <p class="text-wrap" style="word-wrap: break-word;white-space: normal;">Are you sure you want to delete Test <strong> <?= $row['title'] ?>?</strong></p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" name="prosestest" class="btn btn-danger">Delete</button>
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

              <!-- / Content -->

              <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
          </div>
          <!-- / Layout page -->

          <!-- Footer -->
          <?php require 'footer.php'; ?>
          <!-- / Footer -->
        </div>

        <!-- Overlay -->

        <!-- Modal Update -->
        <div class="modal fade" id="add" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Update Data Test</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form method="POST" action=""> <!-- Ensure the action points to the PHP file handling the update -->
                <input type="hidden" name="control" value="add">
                <input type="hidden" name="user_id" value="<?= $id_user ?>">
                <div class="modal-body">
                  <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Judul Test</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" class="form-control" name="title" required />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-info-circle"></i></span>
                        <textarea class="form-control" name="description" required></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Total Score</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-calculator"></i></span>
                        <input type="number" class="form-control" name="totalscore" required min="0" max="100" maxlength="3" />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Class</label>
                    <div class="col-sm-10">
                      <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-school"></i></span>
                        <select class="form-select" name="tingkat" required>
                          <option selected hidden>Pilih Tingkat</option>
                          <option value="X">X</option>
                          <option value="XI">XI</option>
                          <option value="XII">XII</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" name="prosestest" class="btn btn-primary">Save changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>


        <script>
          // Initialize Quill editors
          let quillA1 = new Quill('#editor1', {
            theme: 'snow'
          });
          let quillB1 = new Quill('#editor2', {
            theme: 'snow'
          });
          let quillC1 = new Quill('#editor3', {
            theme: 'snow'
          });
          let quillD1 = new Quill('#editor4', {
            theme: 'snow'
          });

          // On form submission
          document.querySelector('form').onsubmit = function() {
            // Get the Quill editor contents
            document.querySelector('input[name=optionA1]').value = quillA1.root.innerHTML;
            document.querySelector('input[name=optionB1]').value = quillB1.root.innerHTML;
            document.querySelector('input[name=optionC1]').value = quillC1.root.innerHTML;
            document.querySelector('input[name=optionD1]').value = quillD1.root.innerHTML;

            // Clear the Quill editor contents after submission
            quillA1.root.innerHTML = '';
            quillB1.root.innerHTML = '';
            quillC1.root.innerHTML = '';
            quillD1.root.innerHTML = '';

          };
        </script>

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