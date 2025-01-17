<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT koleksipribadi.koleksi_id, user.nama_kategori 
            FROM buku
            INNER JOIN kategori ON buku.kategori_id = kategori.id";
    $query = mysqli_query($koneksi, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }
    echo json_encode($data);

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST: Tambah buku baru dengan kategori
    $nama_buku = $_POST['nama_buku'];
    $jumlah_buku = $_POST['jumlah_buku'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $kategori_id = $_POST['kategori_id'];

    $sql = "INSERT INTO buku (nama_buku, jumlah_buku, tahun_terbit, kategori_id) 
            VALUES ('$nama_buku', '$jumlah_buku', '$tahun_terbit', '$kategori_id')";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        echo json_encode(['status' => 'berhasil', 'message' => 'Buku berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'gagal', 'message' => 'Gagal menambahkan buku']);
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // DELETE: Hapus buku berdasarkan ID
    $id = $_GET['id'];
    $sql = "DELETE FROM buku WHERE id='$id'";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        echo json_encode(['status' => 'berhasil', 'message' => 'Buku berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'gagal', 'message' => 'Gagal menghapus buku']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak valid']);
}
?>
