<!DOCTYPE html>
<?php
$page = "Page Question";
require 'view.php';
require '../../controller/modul.php';
require '../../db/connect.php';


$id = $_GET['id'];
$query = tampildata("SELECT * from tbl_questions where id_test=$id");
$data = mysqli_query($koneksi, "SELECT * from tbl_questions where id_test=$id");
$totaldata = mysqli_num_rows($data);

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
                <div class="col-6 ps-5">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index"> <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Admin</li>
                    <li class="breadcrumb-item"><?= $page ?></li>
                    <li class="breadcrumb-item active">Question</li>
                  </ol>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="card" style="padding:20px">
                <h5 class="card-header p-0 pb-3">Table Question</h5>
                <div class="table-responsive text-nowrap">
                  <button
                    type="button"
                    class="btn btn-primary pb-2"
                    data-bs-toggle="modal"
                    data-bs-target="#add">
                    Tambah Question
                  </button>
                  <table class="table table-hover" id="basic-1">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Text Question</th>
                        <th>Correct Option</th>
                        <th>Score Answer</th>
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
                          <td><?= $row['text_question'] ?></td>
                          <td><?= $row['correctoption'] ?></td>
                          <td><?= $row['scoreanswer'] ?></td>
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



                        <!-- Modal HTML -->
                        <!-- <div class="modal fade" id="ubah<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-fullscreen" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Update Data Question</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action="../../controller/updatequestion.php">
                                <input type="hidden" name="id_test" value="<?= $row['id'] ?>">
                                <input type="hidden" name="control" value="update">
                                <input type="hidden" name="optionA">
                                <input type="hidden" name="optionB">
                                <input type="hidden" name="optionC">
                                <input type="hidden" name="optionD">
                                <div class="modal-body">
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Soal</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" name="text_question" value="<?= $question['text_question'] ?>" required />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Correct Answer</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-school"></i></span>
                                        <select class="form-select" name="tingkat" required>
                                          <option selected hidden>Pilih Opsi</option>
                                          <option value="A" <?= $question['correctoption'] == 'A' ? 'selected' : '' ?>>A</option>
                                          <option value="B" <?= $question['correctoption'] == 'B' ? 'selected' : '' ?>>B</option>
                                          <option value="C" <?= $question['correctoption'] == 'C' ? 'selected' : '' ?>>C</option>
                                          <option value="D" <?= $question['correctoption'] == 'D' ? 'selected' : '' ?>>D</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Nilai Benar</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="number" class="form-control" name="scoreanswer" value="<?= $question['scoreanswer'] ?>" required />
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Option</label>
                                    <div class="col-lg-12 col-md-12">
                                      <div class="row mb-3">
                                        <div class="col-md-6 col-sm-12">
                                          <div class="card overflow-hidden mb-4" style="height: 300px;">
                                            <h5 class="card-header">Option A</h5>
                                            <div class="card-body" id="vertical-example" style="overflow-y: auto;">
                                              <div id="editor1<?= $question['id'] ?>" class="editor"></div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                          <div class="card overflow-hidden mb-4" style="height: 300px;">
                                            <h5 class="card-header">Option C</h5>
                                            <div class="card-body" id="vertical-example" style="overflow-y: auto;">
                                              <div id="editor3<?= $question['id'] ?>" class="editor"></div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <div class="col-md-6 col-sm-12">
                                          <div class="card overflow-hidden mb-4" style="height: 300px;">
                                            <h5 class="card-header">Option B</h5>
                                            <div class="card-body" id="vertical-example" style="overflow-y: auto;">
                                              <div id="editor2<?= $question['id'] ?>" class="editor"></div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                          <div class="card overflow-hidden mb-4" style="height: 300px;">
                                            <h5 class="card-header">Option D</h5>
                                            <div class="card-body" id="vertical-example" style="overflow-y: auto;">
                                              <div id="editor4<?= $question['id'] ?>" class="editor"></div>
                                            </div>
                                          </div>
                                        </div>
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
                        </div> -->





                        <!-- Modal Delete -->
                        <div class="modal fade" id="delete<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Delete Data Modul</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action=""> <!-- Ensure the action points to the PHP file handling the delete -->
                                <input type="hidden" name="id_question" value="<?= $row['id'] ?>" />
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
        <div class="modal-dialog modal-fullscreen" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Data Question</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="../../controller/addquestion.php">
              <input type="hidden" name="control" value="add">
              <input type="hidden" name="id_test" value="<?= htmlspecialchars($id) ?>">
              <input type="hidden" name="optionA1">
              <input type="hidden" name="optionB1">
              <input type="hidden" name="optionC1">
              <input type="hidden" name="optionD1">
              <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Question</label>
                  <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                      <span class="input-group-text"><i class="bx bx-user"></i></span>
                      <input type="text" class="form-control" name="text_question" required />
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Jawaban</label>
                  <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                      <span class="input-group-text"><i class="bx bx-school"></i></span>
                      <select class="form-select" name="answer" required>
                        <option selected hidden>Pilih Opsi</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Nilai Benar</label>
                  <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                      <span class="input-group-text"><i class="bx bx-user"></i></span>
                      <input type="number" class="form-control" name="scoreanswer" required />
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Option</label>
                  <div class="col-lg-12 col-md-12">
                    <div id="editor-container">
                      <div class="editor-row row align-items-start mb-5" id="editor-row-1">
                        <div class="col-lg-10">
                          <div id="editor1" class="editor"></div>
                        </div>
                        <div class="col-lg-1">
                          <input type="text" name="text1" class="form-control" placeholder="Option A/B/C/D" />
                        </div>
                        <div class="col-lg-1">
                          <button type="button" class="btn btn-danger remove-row" data-row-id="1">Hapus</button>
                        </div>
                      </div>
                    </div>
                    <button type="button" id="add-editor" class="btn btn-primary mt-3">Tambah Editor & Input</button>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="prosesquestion" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>


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
            newTextInputContainer.innerHTML = `<input type="text" name="${newInputName}" class="form-control" placeholder="A/B/C/D" />`;

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