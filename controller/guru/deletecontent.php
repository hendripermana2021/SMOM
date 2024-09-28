<?php
require '../../db/connect.php'; // Ensure this path is correct for your project

// Check connection
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

// Include SweetAlert2
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id_content = $_POST['id_content'];
    $id_modul = $_POST['id_modul'];

    // Delete content from tbl_modul_contents
    $delete_content_sql = "DELETE FROM tbl_modul_contents WHERE id = ?";
    $stmt_content = $koneksi->prepare($delete_content_sql);

    if ($stmt_content) {
        $stmt_content->bind_param('i', $id_content);

        if ($stmt_content->execute()) {
            // Success alert
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Content has been successfully deleted.",
                            icon: "success",
                            confirmButtonText: "Ok"
                        }).then(() => {
                            window.location.href = "../../html/guru/tablemodul-detail.php?id=' . $id_modul . '";
                        });
                    });
                  </script>';
            exit();
        } else {
            // Error alert for execution error
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Error",
                            text: "Error executing query: ' . $stmt_content->error . '",
                            icon: "error",
                            confirmButtonText: "Ok"
                        }).then(() => {
                            window.location.href = "../../html/guru/tablemodul-detail.php?id=' . $id_modul . '";
                        });
                    });
                  </script>';
            exit();
        }

        $stmt_content->close();
    } else {
        // Error alert for preparation error
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error",
                        text: "Error preparing statement: ' . $koneksi->error . '",
                        icon: "error",
                        confirmButtonText: "Ok"
                    }).then(() => {
                        window.location.href = "../../html/guru/tablemodul-detail.php?id=' . $id_modul . '";
                    });
                });
              </script>';
        exit();
    }
}

$koneksi->close();
