<?php
require '../db/connect.php';

// Check connection
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id_question = $_POST['id_question'];
    $text_question = $_POST['text_question'];
    $correctoption = $_POST['answer'];
    $scoreanswer = $_POST['scoreanswer'];
    $id_test = $_POST['id_test'];

    // Update question in tbl_questions
    $update_question_sql = "
        UPDATE tbl_questions
        SET text_question = ?, correctoption = ?, scoreanswer = ?
        WHERE id = ?
    ";

    $stmt_question = $koneksi->prepare($update_question_sql);
    $stmt_question->bind_param('ssii', $text_question, $correctoption, $scoreanswer, $id_question);

    if ($stmt_question->execute()) {
        // Retrieve the options from Quill editors
        $optionA = $_POST['optionA'];
        $optionB = $_POST['optionB'];
        $optionC = $_POST['optionC'];
        $optionD = $_POST['optionD'];


        // Check if any of the options are empty
        if (empty($optionA) || empty($optionB) || empty($optionC) || empty($optionD)) {
            echo 'All options (A, B, C, D) must be filled.';
            exit();
        }

        // Update options in tbl_options
        $update_options_query = "
            UPDATE tbl_options
            SET text = CASE
                WHEN label = 'A' THEN ?
                WHEN label = 'B' THEN ?
                WHEN label = 'C' THEN ?
                WHEN label = 'D' THEN ?
            END
            WHERE id_question = ?
        ";

        $stmt_options = $koneksi->prepare($update_options_query);
        $stmt_options->bind_param('ssssi', $optionA, $optionB, $optionC, $optionD, $id_question);

        if ($stmt_options->execute()) {
            // Success
            header('Location: ../html/admin/test-question.php?id=' . $id_test);
            exit();
        } else {
            // Handle error for options update
            echo "Error: " . $update_options_query . "<br>" . $koneksi->error;
        }

        $stmt_options->close();
    } else {
        // Handle error for question update
        echo "Error: " . $update_question_sql . "<br>" . $koneksi->error;
    }

    $stmt_question->close();
}

$koneksi->close();
