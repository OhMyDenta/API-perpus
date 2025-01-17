<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM  buku";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $foto_buku = $_POST['foto_buku'];
    $sql = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit,  foto_buku) VALUES('$judul','$penulis', '$penerbit', '$tahun_terbit','$alamat','$foto_buku')";
    $cekdata = mysqli_query($koneksi, $sql);

    if ($cekdata) {
        $data = ['status' => "berhasil"];
        echo json_encode([$data]);
    } else {
        $data = ['status' => "gagal"];
        echo json_encode([$data]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $buku_id = $_GET['buku_id'];
    $sql = "DELETE FROM buku WHERE buku_id ='$buku_id'";
    $cekdata = mysqli_query($koneksi, $sql);

    if ($cekdata) {
        $data = ['status' => "berhasil"];
        echo json_encode([$data]);
    } else {
        $data = ['status' => "gagal"];
        echo json_encode([$data]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $buku_id = $_GET['buku_id'];
    $judul = $_GET['judul'];
    $penulis = $_GET['penulis'];
    $penerbit = $_GET['penerbit'];
    $tahun_terbit = $_GET['tahun_terbit'];
    $foto_buku = $_GET['foto_buku'];
    $sql = "UPDATE buku SET judul='$judul', penulis='$penulis', penerbit='$penerbit' , tahun_terbit='$tahun_terbit' ,  foto_buku='$foto_buku' WHERE buku_id='$buku_id'";

    $cekdata = mysqli_query($koneksi, $sql);

    if ($cekdata) {
        $data = ['status' => "berhasil"];
        echo json_encode([$data]);
    } else {
        $data = ['status' => "gagal"];
        echo json_encode([$data]);
    }
}