<?php

global $koneksi;
header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost", "root", "", "perpustakaansm");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password_user = $_POST['password_user'];

    $sql = "SELECT * FROM user WHERE username='$username' AND password_user='$password_user'";
    $query = mysqli_query($koneksi, $sql);
    $user = mysqli_fetch_assoc($query);

    if ($user) {
        echo json_encode([
            'status' => 'berhasil',
            'message' => 'Login berhasil',
            'data' => [
                'user_id' => $user['user_id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'nama_lengkap' => $user['nama_lengkap'],
                'role' => $user['role'],
            ]
        ]);
    } else {
        echo json_encode([
            'status' => 'gagal',
            'message' => 'Username atau password salah',
        ]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM user";
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
    $role = $_POST['role'] ?? 'user';

    $sql = "INSERT INTO user (username, password_user, email, nama_lengkap, alamat, foto_profile, role) 
            VALUES('$username','$password_user', '$email', '$nama_lengkap','$alamat','$foto_profile', '$role')";
    $cekdata = mysqli_query($koneksi, $sql);

    if ($cekdata) {
        $data = ['status' => "berhasil"];
        echo json_encode([$data]);
    } else {
        $data = ['status' => "gagal"];
        echo json_encode([$data]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Menghapus user berdasarkan ID
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
    // Memperbarui data user
    parse_str(file_get_contents("php://input"), $_PUT);

    $user_id = $_PUT['user_id'];
    $username = $_PUT['username'];
    $password_user = $_PUT['password_user'];
    $email = $_PUT['email'];
    $nama_lengkap = $_PUT['nama_lengkap'];
    $alamat = $_PUT['alamat'];
    $foto_profile = $_PUT['foto_profile'];
    $role = $_PUT['role'] ?? 'user'; // Jika tidak ada role, default ke 'user'

    $sql = "UPDATE user 
            SET username='$username', password_user='$password_user', email='$email', 
                nama_lengkap='$nama_lengkap', alamat='$alamat', foto_profile='$foto_profile', role='$role' 
            WHERE user_id='$user_id'";
    $cekdata = mysqli_query($koneksi, $sql);

    if ($cekdata) {
        $data = ['status' => "berhasil"];
        echo json_encode([$data]);
    } else {
        $data = ['status' => "gagal"];
        echo json_encode([$data]);
    }
}
