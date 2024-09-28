<?php
require '../db/connect.php'; // Ensure this path is correct for your project

// Check connection
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

// Include SweetAlert2
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';

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
            // Success alert for deletion
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Deleted!",
                            text: "The question has been successfully deleted.",
                            icon: "success",
                            confirmButtonText: "Ok"
                        }).then(() => {
                            window.location.href = "../html/admin/test-question.php?id=' . $id_test . '";
                        });
                    });
                  </script>';
            exit();
        } else {
            // Error alert for question deletion failure
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Error",
                            text: "Failed to delete the question: ' . $stmt_question->error . '",
                            icon: "error",
                            confirmButtonText: "Ok"
                        }).then(() => {
                            window.location.href = "../html/admin/test-question.php?id=' . $id_test . '";
                        });
                    });
                  </script>';
            exit();
        }

        $stmt_question->close();
    } else {
        // Error alert for options deletion failure
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error",
                        text: "Failed to delete options: ' . $stmt_options->error . '",
                        icon: "error",
                        confirmButtonText: "Ok"
                    }).then(() => {
                        window.location.href = "../html/admin/test-question.php?id=' . $id_test . '";
                    });
                });
              </script>';
        exit();
    }

    $stmt_options->close();
}

$koneksi->close();
