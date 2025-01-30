<?php
global $koneksi;
header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost", "root", "", "perpustakaansm");

if (!$koneksi) {
    echo json_encode(['status' => 'error', 'message' => 'Gagal terhubung ke database']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT ulasanbuku.*, 
                   user.username AS username, 
                   buku.judul AS judul 
            FROM ulasanbuku
            INNER JOIN user ON ulasanbuku.user_id = user.user_id
            INNER JOIN buku ON ulasanbuku.buku_id = buku.buku_id";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data);

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $buku_id = $_POST['buku_id'];
    $ulasan = $_POST['ulasan'];
    $rating = $_POST['rating'];

    $sql = "INSERT INTO ulasanbuku (user_id, buku_id, ulasan, rating) 
            VALUES ('$user_id', '$buku_id', '$ulasan', '$rating')";
    $cekdata = mysqli_query($koneksi, $sql);

    if ($cekdata) {
        $data = ['status' => "berhasil", 'message' => "Ulasan berhasil ditambahkan"];
        echo json_encode($data);
    } else {
        $data = ['status' => "gagal", 'message' => "Gagal menambahkan ulasan"];
        echo json_encode($data);
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // parse_str(file_get_contents("php://input"), $_DELETE);
    $ulasan_id = $_DELETE['ulasan_id'];

    $sql = "DELETE FROM ulasanbuku WHERE ulasan_id='$ulasan_id'";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        echo json_encode(['status' => 'berhasil', 'message' => 'Data berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'gagal', 'message' => 'Gagal menghapus data']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak valid']);
}
?>
