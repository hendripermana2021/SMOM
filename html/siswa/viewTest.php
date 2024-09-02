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
$question_text = htmlspecialchars($current_question['text_question']);
$options = tampildata("SELECT id_question, label, text FROM tbl_options WHERE id_question = '$id_question'");
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<!-- Head -->
<?php require 'head.php'; ?>
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
              <div class="col-10">
                <div class="card mb-3">
                  <div class="card-body">
                    <h5 class="card-title">Question <?= $index ?></h5>
                    <form action="../../controller/siswa/add-answer.php" method="post">
                      <input type="hidden" name="test_id" value="<?= $id ?>">
                      <input type="hidden" name="student_id" value="<?= $id_student ?>">
                      <input type="hidden" name="question_id" value="<?= $id_question ?>">
                      <input type="hidden" name="index" value="<?= $index ?>">

                      <p class="card-text mt-3"><?= $question_text ?></p>
                      <div class="list-group">
                        <?php foreach ($options as $option) : ?>
                          <?php
                          $question_id = $option['id_question'];
                          $answer = tampildata("SELECT * FROM tbl_answers WHERE id_test=$id and id_user=$id_student and id_question=$question_id");
                          ?>

                          <label class="list-group-item card-option">
                            <input class="form-check-input me-1" type="radio" name="answer" required value="<?= htmlspecialchars($option['label']) ?>" <?= $option['label'] == $answer[0]['selectoption'] ? 'checked' : '' ?> /><span><?= $option['label'] ?>. <?= htmlspecialchars($option['text']) ?></span>
                          </label>
                        <?php endforeach; ?>
                      </div>

                      <div class="row mt-5">
                        <div class="col-lg-6 col-md-6 col-sm-3">
                          <?php if ($index > 1) : ?>
                            <button type="submit" name="back" class="btn btn-outline-warning">Back</button>
                          <?php endif; ?>
                        </div>
                        <?php
                        if ($index == $totaldata) {
                          $buttonSubmit = '<button type="submit" name="submittest" class="btn btn-primary">Submit</button>';
                        } else {
                          $buttonSubmit = '<button type="submit" name="next" class="btn btn-outline-primary">Next</button>';
                        }
                        ?>
                        <div class="col-lg-6 col-md-6 col-sm-3 text-end">
                          <?= $buttonSubmit ?>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Right Column for displaying question boxes -->
              <div class="col-2">
                <div class="card">
                  <div class="card-body p-2">
                    <h5 class="card-title">Daftar Soal</h5>
                    <div class="row">
                      <?php for ($i = 1; $i <= $totaldata; $i++) : ?>

                        <?php
                        $color = '';
                        if ($i == $index) {
                          $color = 'yellow';
                        } elseif (isset($checkanswer[$i]['selectoption']) == 1) {
                          $color = 'blue';
                        }
                        ?>


                        <div class="col-3 col-lg-6 mb-2">
                          <a href="viewTest.php?id_test=<?= $id ?>&index=<?= $i ?>&id_student=<?= $id_student ?>&id_question=<?= $options[$i]['id_question'] ?>" class="btn question-box <?= $i == $index ? 'btn-primary' : '' ?>" style="background-color: <?= $color ?>; text-align: center; display: block;">
                            <?= $i ?>
                          </a>
                        </div>
                      <?php endfor; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- / Content -->

          <!-- Footer -->
          <?php require './footer.php'; ?>
          <!-- / Footer -->

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/vendor/js/menu.js"></script>
  <script src="../assets/js/main.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>