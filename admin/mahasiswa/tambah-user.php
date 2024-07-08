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

// Ambil data mahasiswa untuk dropdown
$query_mahasiswa = "SELECT npm, nama FROM tb_mahasiswa";
$result_mahasiswa = $conn->query($query_mahasiswa);
$mahasiswa_data = $result_mahasiswa->fetch_all(MYSQLI_ASSOC);

// Proses tambah user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $npm = $_POST["npm"];
    $password = $_POST["password"];

    // Query untuk menambahkan user ke tabel tb_user_mahasiswa
    $query_tambah_user = "INSERT INTO tb_user_mahasiswa (npm, password) VALUES ('$npm', '$password')";
    
    if ($conn->query($query_tambah_user) === TRUE) {
        header("Location: mahasiswa.php");
    } else {
        echo "Error: " . $query_tambah_user . "<br>" . $conn->error;
    }
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User Mahasiswa</title>
    <!-- pakai bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- pakai custom css -->
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Data Mahasiswa</a>
        </div>
    </nav>

	    <div class="konten">
        <div class="tengah">
        <h2>Tambah User</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="npm" class="form-label">NPM Mahasiswa</label>
                <select class="form-select" name="npm" required>
                    <option value="" selected disabled>Pilih NPM Mahasiswa</option>
                    <?php foreach ($mahasiswa_data as $mahasiswa) : ?>
                        <option value="<?= $mahasiswa['npm'] ?>"><?= $mahasiswa['npm'] ?> - <?= $mahasiswa['nama'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah User</button>
        </form>
    </div>
    </div>

</body>
</html>
