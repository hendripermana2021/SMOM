<?php
require '../../db/connect.php'; // Ensure this path is correct for your project

// Check connection
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insert main question data
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $scoreanswer = $_POST['scoreanswer'];
    $id_test = $_POST['id_test'];

    $sql = "INSERT INTO tbl_questions (text_question, correctoption, scoreanswer, id_test) VALUES ('$question', '$answer', '$scoreanswer', '$id_test')";

    if ($koneksi->query($sql) === TRUE) {
        $id_question_created = $koneksi->insert_id; // Get the last inserted question ID

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
                            title: "Error",
                            text: "All options (A, B, C, D) must be filled.",
                            icon: "error",
                            confirmButtonText: "Ok"
                        }).then(() => {
                            window.history.back(); // Go back to the previous page
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
            // Success alert for question and options insertion
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Success!",
                            text: "The question and options have been added successfully.",
                            icon: "success",
                            confirmButtonText: "Ok"
                        }).then(() => {
                            window.location.href = "../../html/guru/test-question.php?id=' . $id_test . '"; // Redirect to test question page
                        });
                    });
                  </script>';
            exit();
        } else {
            // Handle error for options insertion
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Error",
                            text: "Failed to insert options: ' . $koneksi->error . '",
                            icon: "error",
                            confirmButtonText: "Ok"
                        }).then(() => {
                            window.history.back(); // Go back to the previous page
                        });
                    });
                  </script>';
            exit();
        }
    } else {
        // Error alert for question insertion failure
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error",
                        text: "Failed to insert the question: ' . $koneksi->error . '",
                        icon: "error",
                        confirmButtonText: "Ok"
                    }).then(() => {
                        window.history.back(); // Go back to the previous page
                    });
                });
              </script>';
        exit();
    }
}

$koneksi->close();
