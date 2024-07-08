<html>
<head>
    <title>Edit Data Beasiswa</title>
     <!-- pakai bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- pakai custom css -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>" type="text/css">
    <!-- pakai fontawesome buat ikon -->
    <script src="https://kit.fontawesome.com/a4f6a02fea.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Beasiswa Mahasiswa</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="index.php" style="">Pilihan Beasiswa</a></li>
                    <li class="nav-item"><a class="nav-link active" href="daftar-beasiswa.php">Daftar Beasiswa</a></li>
                    <li class="nav-item"><a class="nav-link active" href="hasil-beasiswa.php">Hasil</a></li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link active" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <?php
	// include file koneksi.php buat menghubungkan ke db
    include 'koneksi.php';
    session_start();

    // kalau user belum login, redirect ke halaman login
    if (!isset($_SESSION['npm'])) {
        header("location: login.php");
    }
	
	// ambil npm dari sesi
    $npm = $_SESSION['npm'];

     // query buat mendapatkan data mahasiswa 
    $query_mahasiswa = "SELECT * FROM tb_mahasiswa WHERE NPM = '$npm'";
    $result_mahasiswa = $conn->query($query_mahasiswa);
    $mahasiswa = $result_mahasiswa->fetch_assoc();

    // query buat mendapatkan data pendaftar beasiswa 
    $query_pendaftaran = "SELECT * FROM tb_pendaftaran_beasiswa WHERE npm = '$npm'";
    $result_pendaftaran = $conn->query($query_pendaftaran);
    $pendaftaran = $result_pendaftaran->fetch_assoc();

    $nama = $pendaftaran['nama'];

    // // query buat mendapatkan data pilihan beasiswa
    $query_beasiswa = "SELECT * FROM tb_beasiswa";
    $result_beasiswa = $conn->query($query_beasiswa);
    ?>
    
    <!-- konten utama -->
    <div class="konten">
        <div class="tengah">
            <h2 class="text-center">Edit Data Beasiswa</h2>
            <form action="edit-proses-pendaftaran.php" method="post" enctype="multipart/form-data">
                <table>
                    <!-- form edit  -->
                </table>
                <br/>
                <input type="hidden" name="id_pendaftaran" value="<?php echo $pendaftaran['id_pendaftaran']; ?>">
                <input type="submit" value="Simpan Perubahan">
                <br/>
                <input type="button" value="Batal" class="btn-batal" onclick="location.href='hasil-beasiswa.php';">
            </form>
        </div>
    </div>
</body>
</html>
