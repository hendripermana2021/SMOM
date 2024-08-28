<!DOCTYPE html>

<?php
$id = $_GET['id'];
$test = $_GET['test'];
$id_student = $_SESSION['user_id'];
require './view.php';
require '../../controller/siswa.php';

$query = tampildata("SELECT * from tbl_questions where id_test = $id");
$data = mysqli_query($koneksi, "SELECT * from tbl_questions where id_test = $id");
$totaldata = mysqli_num_rows($data);
?>

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
                    <h5 class="card-title"><?= htmlspecialchars($test) ?></h5>
                    <form action="../../controller/siswa/add-answer.php" method="post">
                      <input type="hidden" name="test_id" value="<?= $id ?>">
                      <input type="hidden" name="student_id" value="<?= $student_id ?>">

                      <?php foreach ($query as $row) : ?>
                        <?php
                        $id_question = $row['id'];
                        $question = tampildata("SELECT * FROM tbl_questions WHERE id = '$id_question'")[0];
                        $options = tampildata("SELECT label, text, id_question FROM tbl_options WHERE id_question = '$id_question'");
                        ?>

                        <p class="card-text mt-3"><?= htmlspecialchars($question['text_question']) ?></p>
                        <div class="list-group">
                          <?php foreach ($options as $option) : ?>
                            <label class="list-group-item">
                              <input class="form-check-input me-1" type="radio" name="answer[<?= $id_question ?>]" required value="<?= htmlspecialchars($option['label']) ?>" />
                              <span><?= $option['label'] ?>. <?= htmlspecialchars($option['text']) ?></span>
                            </label>
                          <?php endforeach; ?>
                        </div>
                      <?php endforeach; ?>

                      <div class="row mt-5">
                        <div class="col-lg-6 col-md-6 col-sm-3">
                          <button type="button" class="btn btn-outline-warning">Back</button>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-3 text-end">
                          <button type="submit" class="btn btn-outline-primary">Next</button>
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
                        <div class="col-4 col-lg-12 mb-2">
                          <a href="test_page.php?id=<?= $id ?>&question=<?= $i ?>" class="btn question-box" style="background-color: yellow; text-align: center; display: block;">
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