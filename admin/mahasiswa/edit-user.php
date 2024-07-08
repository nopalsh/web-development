<?php
include '../../koneksi.php';
include 'koneksi-admin.php';

// mulai sesi buat menyimpan data user yang udah login
    session_start();

    // kalau user belum login, redirect ke halaman login
    if (!isset($_SESSION['user'])) {
        header("location: login.php");
    }

    // ambil npm dari sesi
    $user = $_SESSION['user'];

// Ambil ID user dari parameter URL
$npm = $_GET['npm'];

// Ambil data user berdasarkan npm
$query_user = "SELECT * FROM tb_user_mahasiswa WHERE npm = '$npm'";
$result_user = $conn->query($query_user);

if ($result_user->num_rows > 0) {
    $user_data = $result_user->fetch_assoc();

    // Proses edit user
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil data dari form
        $password = $_POST["password"];

        // Query untuk mengupdate data user
        $query_update_user = "UPDATE tb_user_mahasiswa SET password = '$password' WHERE npm = '$npm'";

        if ($conn->query($query_update_user) === TRUE) {
            header("Location: mahasiswa.php");
        } else {
            echo "Error: " . $query_update_user . "<br>" . $conn->error;
        }
    }
} else {
    echo "User tidak ditemukan.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <!-- pakai bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- pakai custom css -->
    <link rel="stylesheet" href="../../css/style.css">
    <title>Edit User</title>
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Edit User Mahasiswa</a>
        </div>
    </nav>
	    <div class="konten">
        <div class="tengah">
            <h2 class="text-center">Akun Mahasiswa</h2>
        <h2>Edit User</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="npm" class="form-label">NPM Mahasiswa</label>
                <input type="text" class="form-control" name="npm" value="<?= $user_data['npm'] ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
    </div>

</body>
</html>
