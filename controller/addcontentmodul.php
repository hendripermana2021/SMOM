<?php
require '../db/connect.php'; // Ensure this path is correct for your project

if (isset($_POST['prosesmodul'])) {
    // Sanitize input to prevent SQL injection
    $control = mysqli_real_escape_string($koneksi, $_POST['control']);
    $section = mysqli_real_escape_string($koneksi, $_POST['section']);
    $id_modul = mysqli_real_escape_string($koneksi, $_POST['id_modul']);
    $position = mysqli_real_escape_string($koneksi, $_POST['position']);
    $content = mysqli_real_escape_string($koneksi, $_POST['content']); // Assuming you are using a hidden input for content

    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Include SweetAlert2
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>';

    if ($control == "add") {
        // Insert query
        $insert = mysqli_query($koneksi, "INSERT INTO tbl_modul_contents (id_modul, section, content, createdAt, updatedAt, position) 
                                          VALUES ('$id_modul', '$section', '$content', '$created_at', '$updated_at', '$position')");

        // Check if the insert was successful
        if ($insert) {
            // Success alert
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Success",
                            text: "Data berhasil ditambahkan.",
                            icon: "success",
                            confirmButtonText: "Ok"
                        }).then(() => {
                            window.location.href = "../html/admin/tablemodul-detail.php?id=' . $id_modul . '";
                        });
                    });
                  </script>';
            exit();
        } else {
            // Error alert
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Error",
                            text: "Gagal Menambahkan Data: ' . mysqli_error($koneksi) . '",
                            icon: "error",
                            confirmButtonText: "Ok"
                        }).then(() => {
                            window.location.href = "../html/admin/tablemodul-detail.php?id=' . $id_modul . '";
                        });
                    });
                  </script>';
            exit();
        }
    }

    // If the control is not "add", redirect to the details page
    header('Location: ../html/admin/tablemodul-detail.php?id=' . $id_modul);
    exit();
}
