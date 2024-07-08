<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <!-- Tambahkan link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Tambahkan link ke CSS custom -->
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <!-- Tambahkan struktur HTML form untuk input data mahasiswa -->
	    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Tambah Mahasiswa</a>
        </div>
    </nav>
	<?php
// include file koneksi.php untuk menghubungkan ke db
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

// cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ambil data dari form
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $ipk = $_POST['ipk'];

    // query tambah data mahasiswa
    $query_tambah = "INSERT INTO tb_mahasiswa (npm, nama, prodi, ipk) VALUES ('$npm', '$nama', '$prodi', $ipk)";
    $result_tambah = $conn->query($query_tambah);

    if ($result_tambah) {
        // redirect ke halaman mahasiswa.php setelah berhasil tambah
        header("Location: mahasiswa.php");
        exit();
    } else {
        // handle error tambah, misalnya tampilkan pesan error
        $error_message = "Error: " . $conn->error;
    }
}

// Tutup koneksi database
$conn->close();
?>

    <div class="konten">
        <div class="tengah">
        <h2 class="mt-4 mb-4">Tambah Mahasiswa</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="npm" class="form-label">NPM:</label>
                <input type="text" name="npm" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="prodi" class="form-label">Prodi:</label>
                <input type="text" name="prodi" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="ipk" class="form-label">IPK:</label>
                <input type="text" name="ipk" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Tambah Mahasiswa</button>
        </form>

        <!-- Tampilkan pesan error jika terjadi kesalahan -->
        <?php
        if (isset($error_message)) {
            echo "<p class='text-danger'>Error: $error_message</p>";
        }
        ?>
    </div>
    </div>
</body>

</html>
