<?php
require '../../db/connect.php';

// Check connection
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

if (isset($_POST['next'])) {
    // Get the ID of the test, student, and question from the form
    $test_id = $_POST['test_id'];
    $student_id = $_POST['student_id'];
    $question_id = $_POST['question_id'];
    $answer = $_POST['answer'];

    // Check if the student has already answered the question
    $query_check = "SELECT * FROM tbl_answers WHERE id_test = ? AND id_question = ? AND id_user = ?";
    $stmt_check = $koneksi->prepare($query_check);
    $stmt_check->bind_param('iii', $test_id, $question_id, $student_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Answer exists, so update it
        $query_update = "UPDATE tbl_answers SET selectoption = ? WHERE id_test = ? AND id_question = ? AND id_user = ?";
        $stmt_update = $koneksi->prepare($query_update);
        $stmt_update->bind_param('siii', $answer, $test_id, $question_id, $student_id);

        if ($stmt_update->execute()) {
            // Success message or next steps
            header('Location: ../../html/siswa/viewTest.php?id_test=' . $test_id . '&index=' . ($_POST['index'] + 1) . '&id_student=' . $student_id . '&id_question=' . $question_id);
            exit;
        } else {
            echo "Error updating record: " . $stmt_update->error;
        }
    } else {
        // Answer does not exist, insert a new one
        $query_insert = "INSERT INTO tbl_answers (id_test, id_question, id_user, selectoption) 
                         VALUES (?, ?, ?, ?)";
        $stmt_insert = $koneksi->prepare($query_insert);
        $stmt_insert->bind_param('iiis', $test_id, $question_id, $student_id, $answer);

        if ($stmt_insert->execute()) {
            // Success message or next steps
            header('Location: ../../html/siswa/viewTest.php?id_test=' . $test_id . '&index=' . ($_POST['index'] + 1) . '&id_student=' . $student_id . '&id_question=' . $question_id);
            exit;
        } else {
            echo "Error inserting record: " . $stmt_insert->error;
        }
    }

    // Close statements
    $stmt_check->close();
    $stmt_update->close();
    $stmt_insert->close();
}

if (isset($_POST['back'])) {
    // Get the ID of the test, student, and question from the form
    $test_id = $_POST['test_id'];
    $student_id = $_POST['student_id'];
    $question_id = $_POST['question_id'];
    $answer = $_POST['answer'];

    // Check if the student has already answered the question
    $query_check = "SELECT * FROM tbl_answers WHERE id_test = ? AND id_question = ? AND id_user = ?";
    $stmt_check = $koneksi->prepare($query_check);
    $stmt_check->bind_param('iii', $test_id, $question_id, $student_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Answer exists, so update it
        $query_update = "UPDATE tbl_answers SET selectoption = ? WHERE id_test = ? AND id_question = ? AND id_user = ?";
        $stmt_update = $koneksi->prepare($query_update);
        $stmt_update->bind_param('siii', $answer, $test_id, $question_id, $student_id);

        if ($stmt_update->execute()) {
            // Success message or next steps
            header('Location: ../../html/siswa/viewTest.php?id_test=' . $test_id . '&index=' . ($_POST['index'] - 1) . '&id_student=' . $student_id . '&id_question=' . $question_id);
            exit;
        } else {
            echo "Error updating record: " . $stmt_update->error;
        }
    } else {
        // Answer does not exist, insert a new one
        $query_insert = "INSERT INTO tbl_answers (id_test, id_question, id_user, selectoption) 
                         VALUES (?, ?, ?, ?)";
        $stmt_insert = $koneksi->prepare($query_insert);
        $stmt_insert->bind_param('iiis', $test_id, $question_id, $student_id, $answer);

        if ($stmt_insert->execute()) {
            // Success message or next steps
            header('Location: ../../html/siswa/viewTest.php?id_test=' . $test_id . '&index=' . ($_POST['index'] - 1) . '&id_student=' . $student_id . '&id_question=' . $question_id);
            exit;
        } else {
            echo "Error inserting record: " . $stmt_insert->error;
        }
    }

    // Close statements
    $stmt_check->close();
    $stmt_update->close();
    $stmt_insert->close();
}

if (isset($_POST['submittest'])) {
    // Get the ID of the test, student, and question from the form
    $test_id = $_POST['test_id'];
    $student_id = $_POST['student_id'];
    $question_id = $_POST['question_id'];
    $answer = $_POST['answer'];

    $query_check = "SELECT * FROM tbl_answers WHERE id_test = ? AND id_question = ? AND id_user = ?";
    $stmt_check = $koneksi->prepare($query_check);
    $stmt_check->bind_param('iii', $test_id, $question_id, $student_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Answer exists, so update it
        $query_update = "UPDATE tbl_answers SET selectoption = ? WHERE id_test = ? AND id_question = ? AND id_user = ?";
        $stmt_update = $koneksi->prepare($query_update);
        $stmt_update->bind_param('siii', $answer, $test_id, $question_id, $student_id);
        $stmt_update->execute();
    } else {
        // Answer does not exist, insert a new one
        $query_insert = "INSERT INTO tbl_answers (id_test, id_question, id_user, selectoption) 
                         VALUES (?, ?, ?, ?)";
        $stmt_insert = $koneksi->prepare($query_insert);
        $stmt_insert->bind_param('iiis', $test_id, $question_id, $student_id, $answer);
        $stmt_insert->execute();
    }

    // Fetch questions and answers from the database
    $question = mysqli_query($koneksi, "SELECT * FROM tbl_questions WHERE id_test=$test_id");
    $answerQuery = mysqli_query($koneksi, "SELECT * FROM tbl_answers WHERE id_test=$test_id AND id_user=$student_id");

    // Get the total number of questions
    $totaldata = mysqli_num_rows($question);

    $correctAnswer = 0;
    $falseAnswer = 0;
    $score = 0;

    for ($i = 0; $i < $totaldata; $i++) {
        // Fetch the current question and answer
        $currentQuestion = mysqli_fetch_assoc($question);
        $currentAnswer = mysqli_fetch_assoc($answerQuery);

        if ($currentQuestion['correctoption'] == $currentAnswer['selectoption']) {
            $correctAnswer++;
            $score += $currentQuestion['scoreanswer'];
        } else {
            $falseAnswer++;
        }
    }

    // Update the test score and answer count in the database
    $updateTest = mysqli_query($koneksi, "UPDATE tbl_test_answer_score SET score=$score, question_true=$correctAnswer, question_false=$falseAnswer, status_test=0 WHERE id_test=$test_id AND id_student=$student_id");

    // Redirect to the result page
    header('Location: ../../html/siswa/resultTest.php?id_test=' . $test_id . '&id_student=' . $student_id . '&score=' . $score . '&benar=' . $correctAnswer . '&salah=' . $falseAnswer);
    exit;
}

$koneksi->close();
