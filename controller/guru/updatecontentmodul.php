<?php
require '../../db/connect.php';

// Check connection
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id_content = $_POST['id_content'];
    $id_modul = $_POST['id_modul'];
    $section = $_POST['section'];
    $content = $_POST['content'];
    $position = $_POST['position'];

    // Check for empty fields   // Check for empty fields
    if (empty($content) || empty($id_modul) || empty($section) || empty($id_content) || empty($position)) {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error",
                        text: "Data tidak boleh kosong",
                        icon: "error",
                        confirmButtonText: "Ok"
                    }).then(() => {
                        window.history.back();
                    });
                });
              </script>';
        exit(); // Stop execution if there are empty fields
    }

    // Prepare SQL statement to update the content
    $update_sql = "UPDATE tbl_modul_contents SET section = ?, content = ?, position = ? WHERE id = ?";
    $stmt = $koneksi->prepare($update_sql);

    // Bind the parameters in the correct order
    $stmt->bind_param('ssii', $section, $content, $position, $id_content);

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';
    if ($stmt->execute()) {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Success",
                        text: "Data berhasil diperbarui",
                        icon: "success",
                        confirmButtonText: "Ok"
                    }).then(() => {
                        window.location.href = "../../html/guru/tablemodul-detail.php?id=' . $id_modul . '";
                    });
                });
              </script>';
    } else {
        // Handle error with SweetAlert
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error",
                        text: "Gagal memperbarui data: ' . $stmt->error . '",
                        icon: "error",
                        confirmButtonText: "Ok"
                    }).then(() => {
                        window.history.back();
                    });
                });
              </script>';
    }

    $stmt->close();
}

$koneksi->close();
