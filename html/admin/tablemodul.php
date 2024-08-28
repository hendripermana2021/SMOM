<!DOCTYPE html>
<?php
$page = "Page Modul";
require 'view.php';
require '../../controller/modul.php';
$query = tampildata("SELECT * from tbl_moduls");
$data = mysqli_query($koneksi, "SELECT * from tbl_moduls");
$totaldata = mysqli_num_rows($data);

$user_id = $_SESSION['user_id']
?>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template-free">

<!-- Head -->
<?php require './head.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
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
                      <li class="breadcrumb-item active">Modul</li>
                    </ol>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <div class="text-end mb-4">
                      <button
                        type="button"
                        class="btn btn-primary pb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#add">
                        Tambah Modul
                      </button>
                    </div>
                  </div>
                </div>
                <div class="table-responsive text-nowrap">

                  <table class="table table-hover" id="basic-1">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Judul Modul</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Assignment For</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php
                      $index = 1; // Initialize the index variable
                      foreach ($query as $row) :
                        $status = $row['status_post'];
                        if ($status == 'Active') {
                          $statusPost = '<span class="badge bg-label-success">Active</span>';
                        } else {
                          $statusPost = '<span class="badge bg-label-danger">UnActive</span>';
                        }
                      ?>


                        <tr>
                          <td><?= $index++ ?></td> <!-- Output the index and increment it -->
                          <td><?= $row['title'] ?></td>
                          <td><?= $row['subtitle'] ?></td>
                          <td><?= $statusPost ?></td>
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
                                <li><a class="dropdown-item" href="tablemodul-detail.php?id=<?= htmlspecialchars($row['id']) ?>">Add Content</a></li>
                                <li><a class="dropdown-item" href="viewmodul.php?id=<?= htmlspecialchars($row['id']) ?>"> Lihat</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ubah<?= $row['id'] ?>">Edit Modul</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete<?= $row['id'] ?>">Delete Modul</a></li>
                              </ul>
                            </div>
                          </td>
                        </tr>

                        <!-- Modal Update -->
                        <div class="modal fade" id="ubah<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Update Data Modul</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action="" enctype="multipart/form-data"> <!-- Ensure the action points to the PHP file handling the update -->
                                <input type="hidden" name="id_modul" value="<?= $row['id'] ?>">
                                <input type="hidden" name="control" value="update">
                                <div class="modal-body">
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Judul Modul</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" name="title" value="<?= $row['title'] ?>" required />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Subtitle</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-info-circle"></i></span>
                                        <textarea class="form-control" name="subtitle" required><?= $row['subtitle'] ?></textarea>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-calculator"></i></span>
                                        <select class="form-select" name="status_post" required>
                                          <option hidden>Pilih Status</option>
                                          <option value="Active" <?= $row['status_post'] == 'Active' ? 'selected' : '' ?>>Active</option>
                                          <option value="UnActive" <?= $row['status_post'] == 'UnActive' ? 'selected' : '' ?>>UnActive</option>
                                        </select>
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
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Image</label>
                                    <div class="col-sm-10">
                                      <img src="../../assets/img/uploads/<?= $row['image'] ?>" alt="Current Image" class="img-fluid mb-3" style="max-height: 200px;">
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Upload New Image</label>
                                    <div class="col-sm-10">
                                      <div class="input-group">
                                        <label class="input-group-text" for="inputGroupFile01">Upload</label>
                                        <input type="file" class="form-control" name="image" id="inputGroupFile01" />
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" name="prosesmodul" class="btn btn-primary">Save changes</button>
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
                                <h5 class="modal-title">Delete Data Modul</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action=""> <!-- Ensure the action points to the PHP file handling the delete -->
                                <input type="hidden" name="id_modul" value="<?= $row['id'] ?>" />
                                <input type="hidden" name="control" value="delete" />
                                <div class="modal-body">
                                  <p class="text-wrap" style="word-wrap: break-word;white-space: normal;">Are you sure you want to delete Test <strong> <?= $row['title'] ?>?</strong></p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" name="prosesmodul" class="btn btn-danger">Delete</button>
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

      <!-- Modal Add -->
      <div class="modal fade" id="add" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Data Modul</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data">
              <input type="hidden" name="user_id" value="<?= $user_id ?>">
              <input type="hidden" name="control" value="add">
              <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Judul Modul</label>
                  <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                      <span class="input-group-text"><i class="bx bx-user"></i></span>
                      <input type="text" class="form-control" name="title" required />
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Subtitle</label>
                  <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                      <span class="input-group-text"><i class="bx bx-info-circle"></i></span>
                      <textarea class="form-control" name="subtitle" required></textarea>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Status</label>
                  <div class="col-sm-10">
                    <select class="form-select" name="status_post" required>
                      <option hidden>Pilih Status</option>
                      <option value="Active">Active</option>
                      <option value="UnActive">UnActive</option>
                    </select>
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
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Upload Image</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <label class="input-group-text" for="inputGroupFile01">Upload Image</label>
                      <input type="file" class="form-control" name="image" id="inputGroupFile01" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="prosesmodul" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>


      <script>
        document.addEventListener("DOMContentLoaded", function() {
          let editorCount = 1;
          let editorInstances = {};

          // Initialize the first editor
          editorInstances['editor1'] = new Quill('#editor1', {
            theme: 'snow'
          });

          // Add new editor and text input when the button is clicked
          document.getElementById('add-editor').addEventListener('click', function() {
            editorCount++;
            let newEditorId = 'editor' + editorCount;
            let newInputName = 'text' + editorCount;
            let newRowId = 'editor-row-' + editorCount;

            // Create new editor container
            let newEditorRow = document.createElement('div');
            newEditorRow.classList.add('editor-row', 'row', 'align-items-start', 'mb-5');
            newEditorRow.setAttribute('id', newRowId);

            let newEditorContainer = document.createElement('div');
            newEditorContainer.classList.add('col-lg-10');
            newEditorContainer.innerHTML = `<div id="${newEditorId}" class="editor"></div>`;

            // Create new input text
            let newTextInputContainer = document.createElement('div');
            newTextInputContainer.classList.add('col-lg-1');
            newTextInputContainer.innerHTML = `<input type="text" name="${newInputName}" class="form-control" placeholder="Additional Text" />`;

            // Create delete button
            let newButtonContainer = document.createElement('div');
            newButtonContainer.classList.add('col-lg-1');
            newButtonContainer.innerHTML = `<button type="button" class="btn btn-danger remove-row" data-row-id="${editorCount}">Hapus</button>`;

            // Append new editor, input, and delete button to the editor-row div
            newEditorRow.appendChild(newEditorContainer);
            newEditorRow.appendChild(newTextInputContainer);
            newEditorRow.appendChild(newButtonContainer);

            // Append new editor-row to the editor-container div
            document.getElementById('editor-container').appendChild(newEditorRow);

            // Initialize new Quill editor
            editorInstances[newEditorId] = new Quill('#' + newEditorId, {
              theme: 'snow'
            });
          });

          // Remove editor row when delete button is clicked
          document.getElementById('editor-container').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-row')) {
              const rowId = event.target.getAttribute('data-row-id');
              document.getElementById('editor-row-' + rowId).remove();
              delete editorInstances['editor' + rowId]; // Optionally remove the editor instance
            }
          });

          document.querySelector('form').addEventListener('submit', function() {
            Object.keys(editorInstances).forEach(function(key) {
              let editorContent = editorInstances[key].root.innerHTML;
              let input = document.createElement('input');
              input.type = 'hidden';
              input.name = key;
              input.value = editorContent;
              this.appendChild(input);
            }.bind(this));
          });
        });
      </script>

      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Include the Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
      const quill = new Quill('#editor', {
        theme: 'snow'
      });
    </script>

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