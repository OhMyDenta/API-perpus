<?php
global $koneksi;
header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost", "root", "", "perpustakaansm");

if (!$koneksi) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT peminjaman.*, 
                   user.username AS username, 
                   buku.judul AS judul 
            FROM peminjaman
            INNER JOIN user ON peminjaman.user_id = user.user_id
            INNER JOIN buku ON peminjaman.buku_id = buku.buku_id";
    $query = mysqli_query($koneksi, $sql);

    $array_data = [];
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data);

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $buku_id = $_POST['buku_id'];
    $tanggal_peminjaman = date('Y-m-d');

    $sql = "INSERT INTO peminjaman (user_id, buku_id, tanggal_peminjaman, status_peminjaman) 
            VALUES ('$user_id', '$buku_id', '$tanggal_peminjaman', 'dipinjam')";
    $cekdata = mysqli_query($koneksi, $sql);

    if ($cekdata) {
        echo json_encode(['status' => 'berhasil', 'message' => 'Data berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'gagal', 'message' => 'Gagal menambahkan data']);
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $peminjaman_id = $_DELETE['peminjaman_id'];

    $sql = "DELETE FROM peminjaman WHERE peminjaman_id='$peminjaman_id'";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        echo json_encode(['status' => 'berhasil', 'message' => 'Data berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'gagal', 'message' => 'Gagal menghapus data']);
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $peminjaman_id = $_GET['peminjaman_id'];
    $user_id = $_GET['user_id'];
    $buku_id = $_GET['buku_id'];

    $sql = "UPDATE peminjaman SET user_id='$user_id', buku_id='$buku_id' WHERE peminjaman_id='$peminjaman_id'";

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
?>
