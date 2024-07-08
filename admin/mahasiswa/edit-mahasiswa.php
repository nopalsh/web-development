<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>
    <!-- pakai bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- pakai custom css -->
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Edit Mahasiswa</a>
        </div>
    </nav>

    <div class="konten">
	<?php
// include file koneksi.php buat menghubungkan ke db
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

// cek apakah parameter npm ada dalam URL
if (isset($_GET['npm'])) {
    $npm = $_GET['npm'];

    // query untuk mendapatkan data mahasiswa berdasarkan npm
    $query_mahasiswa = "SELECT * FROM tb_mahasiswa WHERE npm = '$npm'";
    $result_mahasiswa = $conn->query($query_mahasiswa);

    // cek apakah data mahasiswa ditemukan
    if ($result_mahasiswa->num_rows > 0) {
        $mahasiswa = $result_mahasiswa->fetch_assoc();
    } else {
        // jika tidak ditemukan, redirect ke halaman utama atau berikan pesan error
        header("Location: mahasiswa.php");
        exit();
    }
} else {
    // jika parameter npm tidak ada, redirect ke halaman utama atau berikan pesan error
    header("Location: mahasiswa.php");
    exit();
}

// proses update data mahasiswa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $ipk = $_POST['ipk'];

    // query update data mahasiswa
    $query_update = "UPDATE tb_mahasiswa SET nama = '$nama', prodi = '$prodi', ipk = '$ipk' WHERE npm = '$npm'";
    $result_update = $conn->query($query_update);

    if ($result_update) {
        // redirect ke halaman mahasiswa.php setelah berhasil update
        header("Location: mahasiswa.php");
        exit();
    } else {
        // handle error update, misalnya tampilkan pesan error
        $error_message = "Error: " . $conn->error;
    }
}

// Tutup koneksi database
$conn->close();
?>
        <div class="tengah">
            <h2 class="text-center">Edit Mahasiswa</h2>

            <!-- Form untuk mengedit data mahasiswa -->
            <form method="post" action="">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $mahasiswa['nama']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <input type="text" class="form-control" id="prodi" name="prodi" value="<?php echo $mahasiswa['prodi']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="ipk" class="form-label">IPK</label>
                    <input type="text" class="form-control" id="ipk" name="ipk" value="<?php echo $mahasiswa['ipk']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>

            <!-- Tampilkan pesan error jika ada -->
            <?php
            if (isset($error_message)) {
                echo "<div class='alert alert-danger mt-3' role='alert'>$error_message</div>";
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-GLhlTQ8iK1uOd8/+PiGgA1INDL4zQx4VoehlTAPAgGT5Yxs9M6D5F5nNKeE2I9/em" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-rvO1TE4FQaW2EGI0I+LqUdoWqwYPXhq72VC8sQ+1l2L6ig7uI5Z/IOWQ0GAtQFzA" crossorigin="anonymous"></script>
</body>
</html>
