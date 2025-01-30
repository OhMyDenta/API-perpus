<?php
global $koneksi;
header('Content-Type: application/json; charset=utf8');

// Koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "perpustakaansm");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT kategoribuku_relasi.*, 
                   kategoribuku.kategori_id,        buku.buku_id 
            FROM kategoribuku_relasi
            INNER JOIN kategoribuku ON kategoribuku_relasi.kategori_id = kategoribuku.kategori_id
            INNER JOIN buku ON kategoribuku_relasi.buku_id = buku.buku_id";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kategori_id = $_POST['kategori_id'];
    $buku_id = $_POST['buku_id'];

    $sql = "INSERT INTO kategoribuku_relasi (kategori_id, buku_id) 
            VALUES ('$kategori_id', '$buku_id')";
    $cekdata = mysqli_query($koneksi, $sql);

    if ($cekdata) {
        $data = ['status' => "berhasil"];
        echo json_encode([$data]);
    } else {
        $data = ['status' => "gagal"];
        echo json_encode([$data]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $kategoribuku_id = $_GET['kategoribuku_id'];
    $sql = "DELETE FROM kategoribuku_relasi WHERE kategoribuku_id='$kategoribuku_id'";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        echo json_encode(['status' => 'berhasil', 'message' => 'data berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'gagal', 'message' => 'Gagal menghapus data']);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $kategoribuku_id = $_GET['kategoribuku_id'];
    $kategori_id = $_GET['kategori_id'];
    $buku_id = $_GET['buku_id'];

    $sql = "UPDATE kategoribuku_relasi SET kategori_id='$kategori_id', buku_id='$buku_id' WHERE kategoribuku_id='$kategoribuku_id'";

    $cekdata = mysqli_query($koneksi, $sql);

    if ($cekdata) {
        $data = ['status' => "berhasil"];
        echo json_encode([$data]);
    } else {
        $data = ['status' => "gagal"];
        echo json_encode([$data]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak valid']);
}
