<?php


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM  user";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password_user = $_POST['password_user'];
    $email = $_POST['email'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];
    $foto_profile = $_POST['foto_profile'];
    $sql = "INSERT INTO user (username, password_user, email, nama_lengkap, alamat, foto_profile) VALUES('$username','$password_user', '$email', '$nama_lengkap','$alamat','$foto_profile')";
    $cekdata = mysqli_query($koneksi, $sql);

    if ($cekdata) {
        $data = ['status' => "berhasil"];
        echo json_encode([$data]);
    } else {
        $data = ['status' => "gagal"];
        echo json_encode([$data]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $user_id = $_GET['user_id'];
    $sql = "DELETE FROM user WHERE user_id ='$user_id'";
    $cekdata = mysqli_query($koneksi, $sql);

    if ($cekdata) {
        $data = ['status' => "berhasil"];
        echo json_encode([$data]);
    } else {
        $data = ['status' => "gagal"];
        echo json_encode([$data]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $user_id = $_GET['user_id'];
    $username = $_GET['username'];
    $password_user = $_GET['password_user'];
    $email = $_GET['email'];
    $nama_lengkap = $_GET['nama_lengkap'];
    $alamat = $_GET['alamat'];
    $foto_profile = $_GET['foto_profile'];
    $sql = "UPDATE user SET username='$username', password_user='$password_user', email='$email' , nama_lengkap='$nama_lengkap' , alamat='$alamat' , foto_profile='$foto_profile' WHERE user_id='$user_id'";

    $cekdata = mysqli_query($koneksi, $sql);

    if ($cekdata) {
        $data = ['status' => "berhasil"];
        echo json_encode([$data]);
    } else {
        $data = ['status' => "gagal"];
        echo json_encode([$data]);
    }
}
