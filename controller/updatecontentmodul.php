<?php
require '../db/connect.php';

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

    // Check for empty fields
    if (empty($content) || empty($id_modul) || empty($section) || empty($id_content) || empty($position)) {
        echo 'Data Kosong';
        exit(); // Stop execution if there are empty fields
    }

    // Prepare SQL statement to update the content
    $update_sql = "UPDATE tbl_modul_contents SET section = ?, content = ?, position = ? WHERE id = ?";
    $stmt = $koneksi->prepare($update_sql);

    // Bind the parameters in the correct order
    $stmt->bind_param('ssii', $section, $content, $position, $id_content);

    if ($stmt->execute()) {
        header('Location: ../html/admin/tablemodul-detail.php?id=' . $id_modul);
        exit(); // Ensure the script stops after redirection
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$koneksi->close();
