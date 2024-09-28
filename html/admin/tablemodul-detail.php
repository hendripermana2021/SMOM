<!DOCTYPE html>
<?php
$page = "Page Modul";
require 'view.php';
$id = $_GET['id'];
$query = tampildata("SELECT * from tbl_modul_contents where id_modul=$id order by position ASC");
$data = mysqli_query($koneksi, "SELECT * from tbl_modul_contents where id_modul=$id");
$totaldata = mysqli_num_rows($data);
?>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template-free">

<!-- Head -->
<?php require './head.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
<script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
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
                  <h3><?= $page ?></h3>
                </div>
                <div class="col-6 ps-5">

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
                      <li class="breadcrumb-item active">Modul Content</li>
                    </ol>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <div class="text-end mb-4">
                      <button
                        type="button"
                        class="btn btn-primary pb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#add">
                        Tambah Content
                      </button>
                    </div>
                  </div>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover" id="basic-1">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Section</th>
                        <th>Position</th>
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
                          <td><?= $row['section'] ?></td>
                          <td><?= $row['position'] ?></td>
                          <td class="text-center col-2">
                            <button
                              type="button"
                              class="btn btn-primary"
                              data-bs-toggle="modal"
                              data-bs-target="#show<?= $row['id'] ?>">
                              Lihat
                            </button>
                            <button
                              type="button"
                              class="btn btn-warning"
                              data-bs-toggle="modal"
                              data-bs-target="#updateModal<?= $row['id'] ?>">
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

                        <!-- Show Modal -->
                        <div class="modal fade" id="show<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-fullscreen" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Lihat Content</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>

                              <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                                <div class="row mb-3">
                                  <label class="col-sm-1 col-form-label">Section</label>
                                  <div class="col-sm-11">
                                    <p><?= $row['section'] ?></p>
                                  </div>
                                </div>
                                <div class="row mb-3">
                                  <label class="col-sm-2 col-form-label">Content</label>
                                  <div class="col-lg-12 col-md-12">
                                    <?= $row['content'] ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Update Modal -->
                        <div class="modal fade" id="updateModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-fullscreen" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Update Content</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" id="update-content<?= $row['id'] ?>" action="../../controller/updatecontentmodul.php">
                                <input type="hidden" name="control" value="update">
                                <input type="hidden" name="content" id="content<?= $row['id'] ?>">
                                <input type="hidden" name="id_content" value="<?= $row['id'] ?>">
                                <input type="hidden" name="id_modul" value="<?= $id ?>">
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
                                    <div class="col-sm-11">
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
                                      </div>
                                      <div id="editor-update<?= $row['id'] ?>" style="height: 1000px;">
                                        <?= $row['content'] ?>
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
                          const quillUpdate<?= $row['id'] ?> = new Quill('#editor-update<?= $row['id'] ?>', {
                            modules: {
                              syntax: true,
                              toolbar: '#toolbar-container-update<?= $row['id'] ?>',
                            },
                            placeholder: 'Compose an epic...',
                            theme: 'snow',
                          });

                          document.querySelector('#update-content<?= $row['id'] ?>').onsubmit = function() {
                            document.querySelector('#content<?= $row['id'] ?>').value = quillUpdate<?= $row['id'] ?>.root.innerHTML;
                          };
                        </script>

                        <!-- Modal Delete -->
                        <div class="modal fade" id="delete<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Delete Data Content</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action="../../controller/deletecontent.php"> <!-- Ensure the action points to the PHP file handling the delete -->
                                <input type="hidden" name="id_content" value="<?= $row['id'] ?>" />
                                <input type="hidden" name="id_modul" value="<?= $id ?>" />
                                <div class="modal-body">
                                  <p class="text-wrap" style="word-wrap: break-word;white-space: normal;">Are you sure you want to delete Test <strong> <?= $row['section'] ?>?</strong></p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-danger">Delete</button>
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
        <!-- Modal Add -->
        <div class="modal fade" id="add" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Tambah Content</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="add-content" method="POST" action="../../controller/addcontentmodul.php">
                <input type="hidden" name="content" id="content">
                <input type="hidden" name="control" value="add">
                <input type="hidden" name="id_modul" value="<?= $id ?>">
                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                  <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Section</label>
                    <div class="col-sm-11">
                      <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-book"></i></span>
                        <input type="text" class="form-control" name="section" required />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-1 col-form-label">Position</label>
                    <div class="col-sm-2">
                      <select name="position" id="position" class="form-select" required>
                        <option value="" selected hidden>-- Pilih --</option>
                        <script>
                          for (let i = 1; i <= 30; i++) {
                            document.write(`<option value="${i}">${i}</option>`);
                          }
                        </script>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Content</label>
                    <div class="col-lg-12 col-md-12">
                      <div id="toolbar-container">
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
                      </div>
                      <div id="editor" style="height: 1000px;">
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
        <!-- / Layout page -->
      </div>

      <script>
        document.querySelector('#add-content').onsubmit = function() {
          document.querySelector('#content').value = quill.root.innerHTML;
        };
      </script>

      <script>
        const quill = new Quill('#editor', {
          modules: {
            syntax: true,
            toolbar: '#toolbar-container',
          },
          placeholder: 'Compose an epic...',
          theme: 'snow',
        });
      </script>

      <!-- Z
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
            newEditorContainer.style.height = '500px';
            newEditorContainer.classList.add('col-lg-10');
            newEditorContainer.innerHTML = `<div id="${newEditorId}" class="editor"></div>`;

            // Create new input text
            let newTextInputContainer = document.createElement('div');
            newTextInputContainer.classList.add('col-lg-1');
            newTextInputContainer.innerHTML = `<input type="text" name="${newInputName}" class="form-control" placeholder="Bagian" />`;

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
      </script> -->

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