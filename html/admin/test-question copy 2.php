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
                              <form id="ubah-form-<?= $row['id'] ?>" method="POST" action="../../controller/updatequestion.php">
                                <input type="hidden" name="control" value="edit">
                                <input type="hidden" name="id_test" value="<?= htmlspecialchars($id) ?>">
                                <input type="hidden" name="id_question" value="<?= $row['id'] ?>">
                                <input type="hidden" name="optionA" />
                                <input type="hidden" name="optionB" />
                                <input type="hidden" name="optionC" />
                                <input type="hidden" name="optionD" />

                                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                                  <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Question</label>
                                    <div class="col-sm-10">
                                      <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" name="text_question" value="<?= $question['text_question'] ?>" required />
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
                                              <textarea class="form-control" name="optionA" rows="5"><?= htmlspecialchars($optionA) ?></textarea>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                          <div class="card overflow-hidden mb-4" style="height: 300px;">
                                            <h5 class="card-header">Option C</h5>
                                            <div class="card-body" style="overflow-y: auto;">
                                              <textarea class="form-control" name="optionC" rows="5"><?= htmlspecialchars($optionC) ?></textarea>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <div class="col-md-6 col-sm-12">
                                          <div class="card overflow-hidden mb-4" style="height: 300px;">
                                            <h5 class="card-header">Option B</h5>
                                            <div class="card-body" style="overflow-y: auto;">
                                              <textarea class="form-control" name="optionB" rows="5"><?= htmlspecialchars($optionB) ?></textarea>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                          <div class="card overflow-hidden mb-4" style="height: 300px;">
                                            <h5 class="card-header">Option D</h5>
                                            <div class="card-body" style="overflow-y: auto;">
                                              <textarea class="form-control" name="optionD" rows="5"><?= htmlspecialchars($optionD) ?></textarea>
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

                        <div class="modal fade" id="delete<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-md" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Delete Question</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form method="POST" action="../../controller/deletequestion.php">
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
        <?php require 'footer.php'; ?>
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
          <form id="add-form" method="POST" action="../../controller/question.php">
            <input type="hidden" name="control" value="insert">
            <input type="hidden" name="id_test" value="<?= htmlspecialchars($id) ?>">
            <input type="hidden" name="optionA">
            <input type="hidden" name="optionB">
            <input type="hidden" name="optionC">
            <input type="hidden" name="optionD">

            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Question</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                    <input type="text" class="form-control" name="text_question" placeholder="Enter Question" required />
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
                          <textarea name="optionA" class="form-control" rows="10" placeholder="Enter Option A"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                      <div class="card overflow-hidden mb-4" style="height: 300px;">
                        <h5 class="card-header">Option C</h5>
                        <div class="card-body" style="overflow-y: auto;">
                          <textarea name="optionC" class="form-control" rows="10" placeholder="Enter Option C"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-6 col-sm-12">
                      <div class="card overflow-hidden mb-4" style="height: 300px;">
                        <h5 class="card-header">Option B</h5>
                        <div class="card-body" style="overflow-y: auto;">
                          <textarea name="optionB" class="form-control" rows="10" placeholder="Enter Option B"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                      <div class="card overflow-hidden mb-4" style="height: 300px;">
                        <h5 class="card-header">Option D</h5>
                        <div class="card-body" style="overflow-y: auto;">
                          <textarea name="optionD" class="form-control" rows="10" placeholder="Enter Option D"></textarea>
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