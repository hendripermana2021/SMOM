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

    // Delete content from tbl_modul_contents
    $delete_content_sql = "DELETE FROM tbl_modul_contents WHERE id = ?";
    $stmt_content = $koneksi->prepare($delete_content_sql);

    if ($stmt_content) {
        $stmt_content->bind_param('i', $id_content);

        if ($stmt_content->execute()) {
            // Redirect to the appropriate page after deletion
            header('Location: ../../html/guru/tablemodul-detail.php?id=' . $id_modul);
            exit();
        } else {
            // Handle execution error
            echo "Error executing query: " . $stmt_content->error;
        }

        $stmt_content->close();
    } else {
        // Handle preparation error
        echo "Error preparing statement: " . $koneksi->error;
    }
}

$koneksi->close();
