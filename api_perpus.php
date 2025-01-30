<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");



header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost", "root", "", "perpustakaansm");

if (!$koneksi) {
    echo json_encode(['status' => 'error', 'message' => 'Koneksi database gagal']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit; 
}

$type = isset($_GET['type']) ? $_GET['type'] : null;

switch ($type) {
    case 'user':
        include 'api_user.php';
        break;

    case 'koleksipribadi':
        include 'koleksi_pribadi.php';
        break;

    case 'buku':
        include 'buku.php';
        break;

    case 'kategoribuku':
        include 'kategoribuku.php';
        break;

    case 'kategoribuku_relasi':
        include 'kategoribuku_relasi.php';
        break;

    case 'ulasanbuku':
        include 'ulasanbuku.php';
        break;

    case 'peminjaman':
        include 'peminjaman.php';
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Endpoint tidak valid']);
}
