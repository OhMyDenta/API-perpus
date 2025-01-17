<?php
header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost", "root", "", "perpustakaansm");

if (!$koneksi) {
    echo json_encode(['status' => 'error', 'message' => 'Koneksi database gagal']);
    exit();
}

$type = isset($_GET['type']) ? $_GET['type'] : null;

switch ($type) {
    case 'user':
        include 'api_user.php';
        break;

    case 'koleksipribadi':
        include 'koleksi_pribadi.php';
        break;

    case 'buku';
        include'buku.dart';
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Endpoint tidak valid']);
}
?>