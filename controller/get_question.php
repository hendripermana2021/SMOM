<?php
require '../../db/connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query_question = "SELECT * FROM tbl_questions WHERE id = ?";
    $stmt = $koneksi->prepare($query_question);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result_question = $stmt->get_result()->fetch_assoc();

    $query_options = "SELECT label, text FROM tbl_options WHERE id_question = ?";
    $stmt_options = $koneksi->prepare($query_options);
    $stmt_options->bind_param("i", $id);
    $stmt_options->execute();
    $result_options = $stmt_options->get_result();

    $options = [];
    while ($option = $result_options->fetch_assoc()) {
        $options[$option['label']] = $option['text'];
    }

    $response = [
        'question' => $result_question,
        'options' => $options,
    ];

    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Invalid ID']);
}
