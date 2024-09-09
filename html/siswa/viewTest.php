<?php
require '../../controller/siswa/add-answer.php';
require '../../db/connect.php'; // Include the database connection
require './view.php';

$id = $_GET['id_test']; // Get the test ID from the URL
$index = isset($_GET['index']) ? $_GET['index'] : 1; // Get the question index from the URL, default to 1 if not set
$id_student = $_SESSION['user_id']; // Get the student ID from the session
$id_question = $_GET['id_question'];

// Fetch the questions for the test
$query = tampildata("SELECT * FROM tbl_questions WHERE id_test = $id");
$data = mysqli_query($koneksi, "SELECT * FROM tbl_questions WHERE id_test = $id");
$totaldata = mysqli_num_rows($data);

// Check if the index is within the range of available questions
if ($index > $totaldata || $index < 1) {
  header('Location: viewTest.php?id_test=' . $id . '&index=1');
  exit;
}

//fetch answer
$checkanswer = tampildata("SELECT * from tbl_answers where id_test=$id and id_user=$id_student");

// Fetch the specific question based on the index
$current_question = $query[$index - 1]; // Index starts from 0 in array
$id_question = $current_question['id'];
$question_text = $current_question['text_question'];
$options = tampildata("SELECT id_question, label, text FROM tbl_options WHERE id_question = '$id_question'");
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

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
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<!-- Include Highlight.js CSS -->
<link href="https://cdn.jsdelivr.net/npm/highlight.js@11.7.0/styles/default.min.css" rel="stylesheet">
<style>
  .custom-radio {
    display: flex;
    align-items: center;
    cursor: pointer;
    position: relative;
  }

  .form-check-input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
  }

  .custom-radio-button {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #007bff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: #007bff;
    margin-right: 8px;
    transition: background-color 0.3s ease;
  }

  .radio-text {
    margin-left: 8px;
    font-size: 14px;
  }

  .form-check-input:checked~.custom-radio-button {
    background-color: #007bff;
    color: #fff;
  }

  p {
    margin-bottom: 0;
  }



  @media (max-width: 574px) {
    .pilgan {
      width: 23%;
      margin-left: 2px;
      text-align: center;
    }

    .btnback {
      width: 50%;
    }

    .btnsubmit {
      width: 50%;
    }
  }
</style>

<!-- END HEAD -->

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar layout-without-menu">
    <div class="layout-container">
      <!-- Layout container -->
      <div class="layout-page">
        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y mt-5">
            <div class="row">
              <!-- Left Column for displaying questions -->
              <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">
                <div class="card mb-3">
                  <div class="card-body" style="padding : 2rem 2rem;">
                    <h5 class="card-title">Question <?= $index ?></h5>
                    <form action="../../controller/siswa/add-answer.php" method="post">
                      <input type="hidden" name="test_id" value="<?= $id ?>">
                      <input type="hidden" name="student_id" value="<?= $id_student ?>">
                      <input type="hidden" name="question_id" value="<?= $id_question ?>">
                      <input type="hidden" name="index" value="<?= $index ?>">
                      <div class="row">
                        <div id="editor">
                          <?= $question_text ?>
                        </div>
                      </div>

                      <div class="list-group">
                        <?php foreach ($options as $option) : ?>
                          <?php
                          $question_id = $option['id_question'];
                          $answer = tampildata("SELECT * FROM tbl_answers WHERE id_test=$id and id_user=$id_student and id_question=$question_id");
                          ?>
                          <div class="row">
                            <label class="list-group-item card-option">
                              <label class="custom-radio">
                                <input class="form-check-input me-1" type="radio" name="answer" value="<?= htmlspecialchars($option['label']) ?>" <?= $option['label'] == $answer[0]['selectoption'] ? 'checked' : '' ?> />
                                <span class="custom-radio-button"><?= htmlspecialchars($option['label']) ?></span>
                                <span class="radio-text"><?= $option['text'] ?></span>
                              </label>
                            </label>
                          </div>
                        <?php endforeach; ?>
                      </div>


                      <div class="row mt-5">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 btnback">
                          <?php if ($index > 1) : ?>
                            <button type="submit" name="back" class="btn btn-outline-warning">Back</button>
                          <?php endif; ?>
                        </div>
                        <?php
                        if ($index == $totaldata) {
                          $buttonSubmit = '<button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#add">Submit</button>';
                        } else {
                          $buttonSubmit = '<button type="submit" name="next" class="btn btn-outline-primary">Next</button>';
                        }
                        ?>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-end btnsubmit">
                          <?= $buttonSubmit ?>
                        </div>
                      </div>

                      <div class="modal fade" id="add" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Konfirmasi Test</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <input type="hidden" name="control" value="add">
                            <div class="modal-body">
                              <div class="row">
                                <label class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-form-label">Apakah anda sudah yakin dengan jawaban anda, klik <strong>Kirim Jawaban</strong> jika sudah selesai</label>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" name="submittest" class="btn btn-primary">Kirim Jawaban</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Right Column for displaying question boxes -->
              <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12">
                <div class="card">
                  <div class="card-body p-3">
                    <h5 class="card-title">Daftar Soal</h5>
                    <div class="row">
                      <?php
                      $i = 1;
                      foreach ($query as $row) : ?>
                        <?php
                        $idQuestion = $row['id'];
                        $answer = mysqli_query($koneksi, "SELECT * FROM tbl_answers WHERE id_test=$id and id_user=$id_student and id_question='$idQuestion'");
                        $checkAnswer = mysqli_num_rows($answer);

                        ?>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-2 col-xs-2 mb-2 pilgan">
                          <a href="viewTest.php?id_test=<?= $id ?>&index=<?= $i ?>&id_student=<?= $id_student ?>&id_question=<?= $options[$i - 1]['id_question'] ?>"
                            class="btn question-box <?= $i == $index ? 'btn-warning' : '' ?>"
                            style="background-color: <?= $checkAnswer == 1 ? 'blue' : '' ?>; text-align: center; display: block;">
                            <?= $i ?>
                          </a>
                        </div>
                      <?php $i++;
                      endforeach;
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

  </div>



  <!-- Core JS -->

  <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
  <!-- Include Highlight.js library -->
  <script src="https://cdn.jsdelivr.net/npm/highlight.js@11.7.0/lib/highlight.js"></script>
  <script>
    const quill = new Quill('#editor', {
      theme: 'snow',
      modules: {
        toolbar: false, // Hide the toolbar
        syntax: true,
      },
      placeholder: 'Compose an epic...',
      readOnly: true // Make the editor read-only
    });
  </script>
  <script>
    document.querySelector('#ubah-form-').onsubmit = function() {
      document.querySelector('#question').value = quillQuestion.root.innerHTML;
      document.querySelector('#optionA').value = quillA.root.innerHTML;
      document.querySelector('#optionB').value = quillB.root.innerHTML;
      document.querySelector('#optionC').value = quillC.root.innerHTML;
      document.querySelector('#optionD').value = quillD.root.innerHTML;
    };
  </script>

  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../../assets/vendor/libs/popper/popper.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>
  <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../../assets/vendor/js/menu.js"></script>
  <script src="../../assets/js/main.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- jQuery (required for DataTables) -->
  <!-- <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> -->
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>


  <script>
    $(document).ready(function() {
      $('#basic-1').DataTable();
    });
  </script>

</body>

</html>