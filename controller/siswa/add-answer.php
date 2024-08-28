<?php
require '../../db/connect.php';

// Check connection
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID of the test, student, and question from the form
    $test_id = $_POST['test_id'];
    $student_id = $_POST['student_id'];
    $question_id = $_POST['question_id'];
    $answer = $_POST['answer'];

    // Insert the answer into the `tbl_answer` table
    $query = "INSERT INTO tbl_answers (id_test, id_question, id_user, selectoption) 
              VALUES ('$test_id', '$question_id', '$student_id', '$answer')";
    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    // Redirect to the next question or a completion page
    header('Location: ../../html/siswa/pageTest.php?id=' . $test_id . '&question=' . ($question_id + 1));
    exit;
}
