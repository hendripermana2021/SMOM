<?php
require '../../db/connect.php';

// Check connection
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id_question = $_POST['id_question'];
    $id_test = $_POST['id_test'];

    // Delete options from tbl_options
    $delete_options_sql = "DELETE FROM tbl_options WHERE id_question = ?";
    $stmt_options = $koneksi->prepare($delete_options_sql);
    $stmt_options->bind_param('i', $id_question);

    if ($stmt_options->execute()) {
        // Delete question from tbl_questions
        $delete_question_sql = "DELETE FROM tbl_questions WHERE id = ?";
        $stmt_question = $koneksi->prepare($delete_question_sql);
        $stmt_question->bind_param('i', $id_question);

        if ($stmt_question->execute()) {
            // Success
            header('Location: ../html/admin/test-question.php?id=' . $id_test);
            exit();
        } else {
            // Handle error for question delete
            echo "Error: " . $delete_question_sql . "<br>" . $koneksi->error;
        }

        $stmt_question->close();
    } else {
        // Handle error for options delete
        echo "Error: " . $delete_options_sql . "<br>" . $koneksi->error;
    }

    $stmt_options->close();
}

$koneksi->close();
