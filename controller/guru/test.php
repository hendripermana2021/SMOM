<?php
require '../../db/connect.php';

if (isset($_POST['prosestest'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
    // Sanitize input to prevent SQL injection
    $control = mysqli_real_escape_string($koneksi, $_POST['control']);
    $title = mysqli_real_escape_string($koneksi, $_POST['title']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);
    $totalscore = mysqli_real_escape_string($koneksi, $_POST['totalscore']);
    $tingkat = mysqli_real_escape_string($koneksi, $_POST['tingkat']);

    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Handle optional 'id_test' only if it exists
    $id_test = isset($_POST['id_test']) ? mysqli_real_escape_string($koneksi, $_POST['id_test']) : null;

    // Initialize query variables
    $query = "";
    $query_type = "";

    // Adjust query based on the control value
    if ($control == "add") {
        $query = "INSERT INTO tbl_tests (title, description, totalscore, for_class, createdAt, updatedAt) 
                  VALUES ('$title', '$description', '$totalscore', '$tingkat', '$created_at', '$updated_at')";
        $query_type = "insert";
    } else if ($control == "update" && $id_test) {
        $query = "UPDATE tbl_tests 
                  SET title='$title', description='$description', totalscore='$totalscore', for_class='$tingkat', updatedAt='$updated_at'
                  WHERE id='$id_test'";
        $query_type = "update";
    } else if ($control == "delete" && $id_test) {
        $query = "DELETE FROM tbl_tests WHERE id='$id_test'";
        $query_type = "delete";
    }

    // Execute query if set
    if ($query) {
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            if ($query_type == "delete") {
                // Additionally delete related questions if it's a delete operation
                $deletequestion = mysqli_query($koneksi, "DELETE FROM tbl_questions WHERE id_test='$id_test'");
            }

            // SweetAlert success notification
            echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "' . ucfirst($control) . ' operation completed successfully.",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "../../html/guru/tabletest.php";
                    });
                  </script>';
            exit();
        } else {
            // SweetAlert error notification
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Failed to process: ' . mysqli_error($koneksi) . '",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "../../html/guru/tabletest.php"; // Redirect to the same page
                    });
                  </script>';
            exit();
        }
    } else {
        // SweetAlert error notification for invalid control or missing ID
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Invalid Control or Missing ID.",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "../../html/guru/tabletest.php"; // Redirect to the same page
                });
              </script>';
        exit();
    }
}

$koneksi->close();
