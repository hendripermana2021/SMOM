<?php
require '../../db/connect.php';

if (isset($_POST['prosestest'])) {
    // Melakukan sanitasi input untuk menghindari SQL Injection
    $control = mysqli_real_escape_string($koneksi, $_POST['control']);
    $title = mysqli_real_escape_string($koneksi, $_POST['title']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);
    $totalscore = mysqli_real_escape_string($koneksi, $_POST['totalscore']);
    $tingkat = mysqli_real_escape_string($koneksi, $_POST['tingkat']);

    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Handling optional 'id_test' only if it exists (e.g., for update or delete)
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
            $_SESSION["sukses"] = 'Data Berhasil Diproses';
        } else {
            $_SESSION["error"] = 'Gagal Proses: ' . mysqli_error($koneksi);
        }
    } else {
        $_SESSION["error"] = 'Gagal Proses: Invalid Control or Missing ID';
    }

    // Redirect back to the same page
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
