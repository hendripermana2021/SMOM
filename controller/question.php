<?php
require '../db/connect.php';

// Check connection
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

if ($_SERVER['REQUEST_METHOD']) {
    // Insert main question data
    $text_question = $_POST['text_question'];
    $answer = $_POST['answer'];
    $scoreanswer = $_POST['scoreanswer'];
    $id_test = $_POST['id_test'];

    $sql = "INSERT INTO tbl_questions (text_question, correctoption, scoreanswer, id_test) VALUES ('$text_question', '$answer', '$scoreanswer', '$id_test')";

    if ($koneksi->query($sql) === TRUE) {
        $id_question_created = $koneksi->insert_id; // Get the last inserted question ID

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

        // Insert options into the database
        $insert_options_query = "INSERT INTO tbl_options (id_question, label, text) VALUES 
        ('$id_question_created', 'A', '$optionA'),
        ('$id_question_created', 'B', '$optionB'),
        ('$id_question_created', 'C', '$optionC'),
        ('$id_question_created', 'D', '$optionD')";

        if ($koneksi->query($insert_options_query) === TRUE) {
            // Success
            header('Location: ../html/admin/test-question.php?id=' . $id_test);
            exit();
        } else {
            // Handle error for options insertion
            echo "Error: " . $insert_options_query . "<br>" . $koneksi->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

$koneksi->close();
