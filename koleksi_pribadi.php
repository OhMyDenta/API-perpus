<?php
global $koneksi;
header('Content-Type: application/json; charset=utf8');

// Koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "perpustakaansm");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT koleksipribadi.*, 
                user.user_id, user.username AS username,
                buku.buku_id, buku.judul AS judul
            FROM koleksipribadi
            INNER JOIN user ON koleksipribadi.user_id = user.user_id
            INNER JOIN buku ON koleksipribadi.buku_id = buku.buku_id";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $buku_id = $_POST['buku_id'];

    $sql = "INSERT INTO koleksipribadi (user_id, buku_id) 
            VALUES ('$user_id', '$buku_id')";
    $cekdata = mysqli_query($koneksi, $sql);

    if ($cekdata) {
        $data = ['status' => "berhasil"];
        echo json_encode([$data]);
    } else {
        $data = ['status' => "gagal"];
        echo json_encode([$data]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $koleksi_id = $_GET['koleksi_id'];
    $sql = "DELETE FROM koleksipribadi WHERE koleksi_id='$koleksi_id'";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        echo json_encode(['status' => 'berhasil', 'message' => 'data berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'gagal', 'message' => 'Gagal menghapus data']);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $koleksi_id = $_GET['koleksi_id'];
    $user_id = $_GET['user_id'];
    $buku_id = $_GET['buku_id'];

    $sql = "UPDATE koleksipribadi SET user_id='$user_id', buku_id='$buku_id' WHERE koleksi_id='$koleksi_id'";

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
