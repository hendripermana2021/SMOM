<!DOCTYPE html>
<?php
$page = "Page Question";
require 'view.php';
require '../../db/connect.php';

$id = $_GET['id'];
$query = tampildata("SELECT * from tbl_questions where id_test=$id");
?>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template-free">

<!-- Head -->
<?php require 'head.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
<script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
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
        <?php require '../admin/navbar.php'; ?>
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
                      <li class="breadcrumb-item active">Question</li>
                    </ol>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <div class="text-end mb-4">
                      <button
                        type="button"
                        class="btn btn-primary pb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#add">
                        Tambah Question
                      </button>
                    </div>
                  </div>
                </div>
                <div class="table-responsive text-nowrap">
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
                      $index = 1;
                      foreach ($query as $row) :
                      ?>
                        <tr>
                          <td><?= $index++ ?></td>
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

                        <?php
                        $id_question = $row['id'];
                        $query_question = "SELECT * FROM tbl_questions WHERE id = '$id_question'";
                        $result_question = mysqli_query($koneksi, $query_question);
                        $question = mysqli_fetch_assoc($result_question);

                        $query_options = "SELECT label, text FROM tbl_options WHERE id_question = '$id_question'";
                        $result_options = mysqli_query($koneksi, $query_options);

                        $options = [];
                        while ($option = mysqli_fetch_assoc($result_options)) {
                          $options[$option['label']] = $option['text'];
                        }

                        $optionA = $options['A'] ?? '';
                        $optionB = $options['B'] ?? '';
                        $optionC = $options['C'] ?? '';
                        $optionD = $options['D'] ?? '';
                        ?>
                        <div class="modal fade" id="ubah<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-fullscreen" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Ubah Data Question</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form id="ubah-form-<?= $row['id'] ?>" method="POST" action="../../controller/guru/updatequestion.php">
                                <input type="hidden" name="control" value="edit">
                                <input type="hidden" name="id_test" value="<?= htmlspecialchars($id) ?>">
                                <input type="hidden" name="id_question" value="<?= $row['id'] ?>">
                                <input type="hidden" name="question" id="question<?= $row['id'] ?>">
                                <input type="hidden" name="optionA" id="optionA<?= $row['id'] ?>">
                                <input type="hidden" name="optionB" id="optionB<?= $row['id'] ?>">
                                <input type="hidden" name="optionC" id="optionC<?= $row['id'] ?>">
                                <input type="hidden" name="optionD" id="optionD<?= $row['id'] ?>">

                                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Question</label>
                                    <div class="col-sm-10">
                                      <div id="toolbar-containerQuestion<?= $row['id'] ?>">
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
                                      <div id="editorQuestion<?= $row['id'] ?>" style="height: 200px;">
                                        <?= $row['text_question'] ?>
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
                                            <div class="card-body" style="overflow-y: auto;">
                                              <div id="toolbar-containerA<?= $row['id'] ?>">
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
                                              <div id="editorA<?= $row['id'] ?>" style="height: 200px;">
                                                <?= $optionA ?>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                          <div class="card overflow-hidden mb-4" style="height: 300px;">
                                            <h5 class="card-header">Option C</h5>
                                            <div class="card-body" style="overflow-y: auto;">
                                              <div id="toolbar-containerC<?= $row['id'] ?>">
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
                                              <div id="editorC<?= $row['id'] ?>" style="height: 200px;">
                                                <?= $optionC ?>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <div class="col-md-6 col-sm-12">
                                          <div class="card overflow-hidden mb-4" style="height: 300px;">
                                            <h5 class="card-header">Option B</h5>
                                            <div class="card-body" style="overflow-y: auto;">
                                              <div id="toolbar-containerB<?= $row['id'] ?>">
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
                                              <div id="editorB<?= $row['id'] ?>" style="height: 200px;">
                                                <?= $optionB ?>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                          <div class="card overflow-hidden mb-4" style="height: 300px;">
                                            <h5 class="card-header">Option D</h5>
                                            <div class="card-body" style="overflow-y: auto;">
                                              <div id="toolbar-containerD<?= $row['id'] ?>">
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
                                              <div id="editorD<?= $row['id'] ?>" style="height: 200px;">
                                                <?= $optionD ?>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <script>
                          const quillQuestion<?= $row['id'] ?> = new Quill('#editorQuestion<?= $row['id'] ?>', {
                            modules: {
                              syntax: true,
                              toolbar: '#toolbar-containerQuestion<?= $row['id'] ?>',
                            },
                            placeholder: 'Compose an epic...',
                            theme: 'snow',
                          });
                          const quillA<?= $row['id'] ?> = new Quill('#editorA<?= $row['id'] ?>', {
                            modules: {
                              syntax: true,
                              toolbar: '#toolbar-containerA<?= $row['id'] ?>',
                            },
                            placeholder: 'Compose an epic...',
                            theme: 'snow',
                          });
                          const quillB<?= $row['id'] ?> = new Quill('#editorB<?= $row['id'] ?>', {
                            modules: {
                              syntax: true,
                              toolbar: '#toolbar-containerB<?= $row['id'] ?>',
                            },
                            placeholder: 'Compose an epic...',
                            theme: 'snow',
                          });
                          const quillC<?= $row['id'] ?> = new Quill('#editorC<?= $row['id'] ?>', {
                            modules: {
                              syntax: true,
                              toolbar: '#toolbar-containerC<?= $row['id'] ?>',
                            },
                            placeholder: 'Compose an epic...',
                            theme: 'snow',
                          });
                          const quillD<?= $row['id'] ?> = new Quill('#editorD<?= $row['id'] ?>', {
                            modules: {
                              syntax: true,
                              toolbar: '#toolbar-containerD<?= $row['id'] ?>',
                            },
                            placeholder: 'Compose an epic...',
                            theme: 'snow',
                          });
                        </script>
                        <script>
                          document.querySelector('#ubah-form-<?= $row['id'] ?>').onsubmit = function() {
                            document.querySelector('#question<?= $row['id'] ?>').value = quillQuestion<?= $row['id'] ?>.root.innerHTML;
                            document.querySelector('#optionA<?= $row['id'] ?>').value = quillA<?= $row['id'] ?>.root.innerHTML;
                            document.querySelector('#optionB<?= $row['id'] ?>').value = quillB<?= $row['id'] ?>.root.innerHTML;
                            document.querySelector('#optionC<?= $row['id'] ?>').value = quillC<?= $row['id'] ?>.root.innerHTML;
                            document.querySelector('#optionD<?= $row['id'] ?>').value = quillD<?= $row['id'] ?>.root.innerHTML;
                          };
                        </script>

                        <div class="modal fade" id="delete<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-md" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Delete Question</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action="../../controller/guru/deletequestion.php">
                                <input type="hidden" name="control" value="delete">
                                <input type="hidden" name="id_question" value="<?= $row['id'] ?>">
                                <input type="hidden" name="id_test" value="<?= htmlspecialchars($id) ?>">
                                <div class="modal-body">
                                  <h5 class="text-center">Are you sure you want to delete this question?</h5>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" value="" class="btn btn-danger">Delete</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- / Content -->

        <!-- Footer -->
        <?php require '../admin/footer.php'; ?>
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
      </div>
      <!-- Content wrapper -->
    </div>
    <div class="modal fade" id="add" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Question</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="add-question" method="POST" action="../../controller/guru/addquestion.php">
            <input type="hidden" name="control" value="insert">
            <input type="hidden" name="question" id="question">
            <input type="hidden" name="optionA" id="optionA">
            <input type="hidden" name="optionB" id="optionB">
            <input type="hidden" name="optionC" id="optionC">
            <input type="hidden" name="optionD" id="optionD">
            <input type="hidden" name="id_test" value="<?= htmlspecialchars($id) ?>">

            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Question</label>
                <div class="col-sm-10">
                  <div id="toolbar-containerQuestion">
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
                  <div id="editorQuestion" style="height: 200px;">
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
                    <input type="number" class="form-control" name="scoreanswer" placeholder="Enter Score" required />
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
                        <div class="card-body" style="overflow-y: auto;">
                          <div id="toolbar-containerA">
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
                          <div id="editorA" style="height: 200px;">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                      <div class="card overflow-hidden mb-4" style="height: 300px;">
                        <h5 class="card-header">Option C</h5>
                        <div class="card-body" style="overflow-y: auto;">
                          <div id="toolbar-containerC">
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
                          <div id="editorC" style="height: 200px;">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-6 col-sm-12">
                      <div class="card overflow-hidden mb-4" style="height: 300px;">
                        <h5 class="card-header">Option B</h5>
                        <div class="card-body" style="overflow-y: auto;">
                          <div id="toolbar-containerB">
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
                          <div id="editorB" style="height: 200px;">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                      <div class="card overflow-hidden mb-4" style="height: 300px;">
                        <h5 class="card-header">Option D</h5>
                        <div class="card-body" style="overflow-y: auto;">
                          <div id="toolbar-containerD">
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
                          <div id="editorD" style="height: 200px;">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- / Layout container -->
  </div>
  <!-- / Layout wrapper -->

  <script>
    const quillQuestion = new Quill('#editorQuestion', {
      modules: {
        syntax: true,
        toolbar: '#toolbar-containerQuestion',
      },
      placeholder: 'Compose an epic...',
      theme: 'snow',
    });
    const quillA = new Quill('#editorA', {
      modules: {
        syntax: true,
        toolbar: '#toolbar-containerA',
      },
      placeholder: 'Compose an epic...',
      theme: 'snow',
    });
    const quillB = new Quill('#editorB', {
      modules: {
        syntax: true,
        toolbar: '#toolbar-containerB',
      },
      placeholder: 'Compose an epic...',
      theme: 'snow',
    });
    const quillC = new Quill('#editorC', {
      modules: {
        syntax: true,
        toolbar: '#toolbar-containerC',
      },
      placeholder: 'Compose an epic...',
      theme: 'snow',
    });
    const quillD = new Quill('#editorD', {
      modules: {
        syntax: true,
        toolbar: '#toolbar-containerD',
      },
      placeholder: 'Compose an epic...',
      theme: 'snow',
    });
  </script>
  <script>
    document.querySelector('#add-question').onsubmit = function() {
      document.querySelector('#question').value = quillQuestion.root.innerHTML;
      document.querySelector('#optionA').value = quillA.root.innerHTML;
      document.querySelector('#optionB').value = quillB.root.innerHTML;
      document.querySelector('#optionC').value = quillC.root.innerHTML;
      document.querySelector('#optionD').value = quillD.root.innerHTML;
    };
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
  <!-- build:js assets/vendor/js/core.js -->
  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../../assets/vendor/libs/popper/popper.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>
  <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../../assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->

  <!-- Main JS -->
  <script src="../../assets/js/main.js"></script>

  <!-- Page JS -->

  <!-- Quill JS -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.min.js"></script> -->

  <!-- <script>
    const editors = {};

    document.addEventListener("DOMContentLoaded", function() {
      // Initialize Quill editors
      document.querySelectorAll('.editor').forEach(function(editorElement) {
        const editorId = editorElement.id;
        editors[editorId] = new Quill('#' + editorId, {
          theme: 'snow'
        });
      });

      // Event listener for form submissions
      document.querySelectorAll('form').forEach(function(formElement) {
        formElement.addEventListener('submit', function(event) {
          event.preventDefault();

          const formId = formElement.id;

          if (formId.includes("add-form")) {
            formElement.querySelector('input[name="optionA"]').value = editors['editorA'].root.innerHTML;
            formElement.querySelector('input[name="optionB"]').value = editors['editorB'].root.innerHTML;
            formElement.querySelector('input[name="optionC"]').value = editors['editorC'].root.innerHTML;
            formElement.querySelector('input[name="optionD"]').value = editors['editorD'].root.innerHTML;
          } else {
            // Safely attempt to find the elements before accessing their properties
            const optionA2Input = formElement.querySelector('input[name="optionA"]');
            const optionB2Input = formElement.querySelector('input[name="optionB"]');
            const optionC2Input = formElement.querySelector('input[name="optionC"]');
            const optionD2Input = formElement.querySelector('input[name="optionD"]');

            if (optionA2Input && optionB2Input && optionC2Input && optionD2Input) {
              const editorAId = optionA2Input.name.replace("optionA", "editorA");
              const editorBId = optionB2Input.name.replace("optionB", "editorB");
              const editorCId = optionC2Input.name.replace("optionC", "editorC");
              const editorDId = optionD2Input.name.replace("optionD", "editorD");

              console.log(editorAId);
              console.log(editorBId);
              console.log(editorCId);
              console.log(editorDId);

              formElement.querySelector('input[name="optionA"]').value = editors[editorAId].root.innerHTML;
              formElement.querySelector('input[name="optionB"]').value = editors[editorBId].root.innerHTML;
              formElement.querySelector('input[name="optionC"]').value = editors[editorCId].root.innerHTML;
              formElement.querySelector('input[name="optionD"]').value = editors[editorDId].root.innerHTML;
            } else {
              console.error('One or more input elements could not be found');
            }
          }

          formElement.submit();
        });
      });
    });
  </script> -->
</body>

</html>