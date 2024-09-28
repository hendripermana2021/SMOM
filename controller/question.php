<?php
require '../db/connect.php';

// Check connection
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input to prevent SQL Injection
    $text_question = mysqli_real_escape_string($koneksi, $_POST['text_question']);
    $answer = mysqli_real_escape_string($koneksi, $_POST['answer']);
    $scoreanswer = mysqli_real_escape_string($koneksi, $_POST['scoreanswer']);
    $id_test = mysqli_real_escape_string($koneksi, $_POST['id_test']);

    $sql = "INSERT INTO tbl_questions (text_question, correctoption, scoreanswer, id_test) VALUES ('$text_question', '$answer', '$scoreanswer', '$id_test')";

    if ($koneksi->query($sql) === TRUE) {
        $id_question_created = $koneksi->insert_id; // Get the last inserted question ID

        // Retrieve the options from Quill editors
        $optionA = mysqli_real_escape_string($koneksi, $_POST['optionA']);
        $optionB = mysqli_real_escape_string($koneksi, $_POST['optionB']);
        $optionC = mysqli_real_escape_string($koneksi, $_POST['optionC']);
        $optionD = mysqli_real_escape_string($koneksi, $_POST['optionD']);

        // Check if any of the options are empty
        if (empty($optionA) || empty($optionB) || empty($optionC) || empty($optionD)) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Error",
                            text: "All options (A, B, C, D) must be filled.",
                            icon: "error",
                            confirmButtonText: "Ok"
                        }).then(() => {
                            window.history.back();
                        });
                    });
                  </script>';
            exit();
        }

        // Insert options into the database
        $insert_options_query = "INSERT INTO tbl_options (id_question, label, text) VALUES 
        ('$id_question_created', 'A', '$optionA'),
        ('$id_question_created', 'B', '$optionB'),
        ('$id_question_created', 'C', '$optionC'),
        ('$id_question_created', 'D', '$optionD')";

        if ($koneksi->query($insert_options_query) === TRUE) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Success",
                            text: "Question and options added successfully.",
                            icon: "success",
                            confirmButtonText: "Ok"
                        }).then(() => {
                            window.location.href = "../html/admin/test-question.php?id=' . $id_test . '";
                        });
                    });
                  </script>';
        } else {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Error",
                            text: "Failed to insert options: ' . $koneksi->error . '",
                            icon: "error",
                            confirmButtonText: "Ok"
                        }).then(() => {
                            window.history.back();
                        });
                    });
                  </script>';
        }
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error",
                        text: "Failed to insert question: ' . $koneksi->error . '",
                        icon: "error",
                        confirmButtonText: "Ok"
                    }).then(() => {
                        window.history.back();
                    });
                });
              </script>';
    }
}

$koneksi->close();
