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

    if (empty($content) || empty($id_modul) || empty($section) || empty($id_content)) {
        echo 'Data Kosong';
    }

    // Prepare SQL statement to update the content
    $update_sql = "UPDATE tbl_modul_contents SET section = ?, content = ? WHERE id = ?";
    $stmt = $koneksi->prepare($update_sql);
    $stmt->bind_param('ssi', $section, $content, $id_content);

    if ($stmt->execute()) {
        header('Location: ../html/admin/tablemodul-detail.php?id=' . $id_modul);
        // exit();
    } else {
        // Handle error
        echo "Error: " . $update_sql . "<br>" . $koneksi->error;
    }

    $stmt->close();
}

$koneksi->close();
