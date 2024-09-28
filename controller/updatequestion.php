<?php
require '../db/connect.php';

// Check connection
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}


echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $id_question = $_POST['id_question'];
    $question = $_POST['question'];
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
    $stmt_question->bind_param('ssii', $question, $correctoption, $scoreanswer, $id_question);

    if ($stmt_question->execute()) {
        // Retrieve the options from Quill editors
        $optionA = $_POST['optionA'];
        $optionB = $_POST['optionB'];
        $optionC = $_POST['optionC'];
        $optionD = $_POST['optionD'];

        // Check if any of the options are empty
        if (empty($optionA) || empty($optionB) || empty($optionC) || empty($optionD)) {
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "All options (A, B, C, D) must be filled.",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.history.back(); // Go back to the previous page
                        });
                    });
                  </script>';
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
            // Success message with SweetAlert
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: "Question and options updated successfully.",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href = "../html/admin/test-question.php?id=' . $id_test . '";
                        });
                    });
                  </script>';
            exit();
        } else {
            // Handle error for options update
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "Error updating options: ' . $koneksi->error . '",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.history.back(); // Go back to the previous page
                        });
                    });
                  </script>';
            exit();
        }

        $stmt_options->close();
    } else {
        // Handle error for question update
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Error updating question: ' . $koneksi->error . '",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.history.back(); // Go back to the previous page
                    });
                });
              </script>';
        exit();
    }

    $stmt_question->close();
}

$koneksi->close();
