<?php
require '../../db/connect.php';

if (isset($_POST['prosestest'])) {
    // Sanitize input to prevent SQL Injection
    $control = $_POST['control'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $totalscore = $_POST['totalscore'];
    $tingkat = $_POST['tingkat'];
    $user_id = $_POST['user_id'];

    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Handling optional 'id_test' only if it exists (for update or delete)
    $id_test = isset($_POST['id_test']) ? $_POST['id_test'] : null;

    // Initialize prepared statement variables
    $stmt = null;

    // Adjust query based on the control value
    if ($control == "add") {
        $stmt = $koneksi->prepare("INSERT INTO tbl_tests (title, description, totalscore, for_class, createdAt, updatedAt, id_users) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisssi", $title, $description, $totalscore, $tingkat, $created_at, $updated_at, $user_id);
    } else if ($control == "update" && $id_test) {
        $stmt = $koneksi->prepare("UPDATE tbl_tests 
                  SET title=?, description=?, totalscore=?, for_class=?, updatedAt=?
                  WHERE id=?");
        $stmt->bind_param("ssissi", $title, $description, $totalscore, $tingkat, $updated_at, $id_test);
    } else if ($control == "delete" && $id_test) {
        $stmt = $koneksi->prepare("DELETE FROM tbl_tests WHERE id=?");
        $stmt->bind_param("i", $id_test);
    }

    // Execute query if statement is set
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
    if ($stmt && $stmt->execute()) {
        if ($control == "delete") {
            // Additionally delete related questions if it's a delete operation
            $delete_question_stmt = $koneksi->prepare("DELETE FROM tbl_questions WHERE id_test=?");
            $delete_question_stmt->bind_param("i", $id_test);
            $delete_question_stmt->execute();
        }
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Success",
                        text: "Data Berhasil Diproses",
                        icon: "success",
                        confirmButtonText: "Ok"
                    }).then(() => {
                        window.location.href = "' . $_SERVER['PHP_SELF'] . '";
                    });
                });
              </script>';
    } else {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error",
                        text: "Gagal Proses: ' . $koneksi->error . '",
                        icon: "error",
                        confirmButtonText: "Ok"
                    }).then(() => {
                        window.history.back();
                    });
                });
              </script>';
    }

    $stmt->close();
    $koneksi->close();
}
