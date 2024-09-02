<?php
require '../../db/connect.php';
session_start();

if (isset($_POST['confirm'])) {
    // Melakukan sanitasi input untuk menghindari SQL Injection
    $id_test = $_POST['id_test'];
    $id_student = $_SESSION['user_id'];
    $status_test = 1;
    $control = $_POST['control'];

    // Check if the record already exists
    $query_check = mysqli_query($koneksi, "SELECT * FROM tbl_test_answer_score WHERE id_test='$id_test' AND id_student='$id_student' AND status_test='$status_test'");

    if (mysqli_num_rows($query_check) > 0) {
    } else {
        // Proceed with the insertion if record does not exist
        if ($control == "add") {
            $insert = mysqli_query($koneksi, "INSERT INTO tbl_test_answer_score (id_test, id_student, status_test) 
                                              VALUES ('$id_test','$id_student', '$status_test')");
        }

        // Handling the result of the queries
        if ((isset($insert) && $insert)) {
            $_SESSION["sukses"] = 'Data Berhasil Diproses';
        } else {
            $_SESSION["error"] = 'Gagal Proses';
        }
    }

    header('Location: ./viewTest.php?id_test=' . $id_test . '&index=0&id_student= ' . $id_student);
    exit();
}
