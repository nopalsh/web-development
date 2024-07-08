<html>
<head>
    <title>Hasil Beasiswa</title>
    <!-- pakai bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- pakai custom css -->
    <link href="css/style.css?v=<?php echo time() ?>" rel="stylesheet" type="text/css">
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
                    <li class="nav-item"><a class="nav-link active" href="index.php">Pilihan Beasiswa</a></li>
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

    // mulai sesi buat menyimpan data user yang udah login
    session_start();

    // kalau user belum login, redirect ke halaman login
    if (!isset($_SESSION['npm'])) {
        header("location: login.php");
		exit;
    }

    // ambil npm dari sesi
    $npm = $_SESSION['npm'];

    // query buat mendapatkan data mahasiswa berdasarkan npm
    $query_mahasiswa = "SELECT * FROM tb_mahasiswa WHERE NPM = '$npm'";
    $result_mahasiswa = $conn->query($query_mahasiswa);
    $mahasiswa = $result_mahasiswa->fetch_assoc();

    // query buat mendapatkan data pendaftaran beasiswa berdasarkan npm mahasiswa
    $query_pendaftaran = "SELECT * FROM tb_pendaftaran_beasiswa WHERE npm = '{$mahasiswa['npm']}'";
    $result_pendaftaran = $conn->query($query_pendaftaran);
    $pendaftaran = $result_pendaftaran->fetch_assoc();

    // klau ada pendaftaran, ambil nama beasiswa yang dipilih
    if ($pendaftaran) {
        $query_beasiswa = "SELECT nama_beasiswa FROM tb_beasiswa WHERE id_beasiswa = '{$pendaftaran['pilihan_beasiswa']}'";
        $result_beasiswa = $conn->query($query_beasiswa);
        $beasiswa = $result_beasiswa->fetch_assoc();
    }
    ?>
	
    <div class="konten">
        <div class="tengah">
		
            <h2 class="text-center"><i class="fas fa-star"></i> Hasil Penerimaan Beasiswa</h2>
            <?php if ($pendaftaran) : ?>
                <div class="input-container">
                    <span class="input-label">Status</span>
                    <input class="input-field" value="<?php echo $pendaftaran['status_ajuan']; ?>" readonly data-status="<?php echo $pendaftaran['status_ajuan']; ?>">
                </div>
            <?php else : ?>
                <br />
                <p>Kamu belum mendaftarkan beasiswa.</p>
            <?php endif; ?>
        </div>
    </div>
	<!-- konten utama -->
    <div class="konten">
        <div class="tengah">
            <h2 class="text-center"><i class="fa-regular fa-user"></i> Data Mahasiswa Pendaftar Beasiswa</h2>
            <?php if ($pendaftaran) : ?>
                <!-- menampilkan data mahasiswa pendaftar beasiswa -->
                <div class="input-container">
                    <span class="input-label">Nama</span>
                    <input class="input-field" value="<?php echo $pendaftaran['nama']; ?>" readonly>
                </div>
                <div class="input-container">
                    <span class="input-label">Email</span>
                    <input class="input-field" value="<?php echo $pendaftaran['email']; ?>" readonly>
                </div>
                <div class="input-container">
                    <span class="input-label">Nomor HP</span>
                    <input class="input-field" value="<?php echo $pendaftaran['no_hp']; ?>" readonly>
                </div>
                <div class="input-container">
                    <span class="input-label">Semester</span>
                    <input class="input-field" value="<?php echo $pendaftaran['semester']; ?>" readonly>
                </div>
                <div class="input-container">
                    <span class="input-label">IPK</span>
                    <input class="input-field" value="<?php echo $pendaftaran['ipk_terakhir']; ?>" readonly>
                </div>
                <div class="input-container">
                    <span class="input-label">Pilihan Beasiswa</span>
                    <input class="input-field" value="<?php echo $beasiswa['nama_beasiswa']; ?>" readonly>
                </div>
                <div class="input-container">
                    <span class="input-label">Berkas</span>
                    <p><a href="<?php echo $pendaftaran['upload_berkas']; ?>" target="_blank" class="link-berkas">Lihat Berkas</a></p>
					<p><a href="edit-pendaftaran.php" class="btn-edit">Edit Data Pendaftaran</a></p>
                </div>
            <?php else : ?>
                <br />
                <p>Kamu belum mendaftarkan beasiswa.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="konten">
        <h2 class="text-center"><i class="fa-regular fa-calendar"></i>&nbsp Timeline</h2>
        <div class="tengah">
            <div class="timeline">
                <?php
                // proses timeline beserta tanggalnya dalam array
                $processes = array(
                    //"Wawancara" => "2023-11-01",
                    "Pengumuman Hasil" => "2023-12-04",
                    "Proses Verifikasi Data" => "2023-12-02",
					"Seleksi" => "2023-12-03",
					"Pendaftaran Di Buka" => "2023-12-01",
                );

                // urutkan timeline berdasarkan tanggal
                uasort($processes, function ($a, $b) {
                    return strtotime($a) - strtotime($b);
                });
                ?>

                <?php
                // menampilan timeline
                foreach ($processes as $process => $date) {
                    echo '<div class="card-timeline">';
                    echo '<span class="date-timeline">' . $date . '</span>';
                    echo '<br/>';
                    echo '<span class="desc-timeline">' . $process . '</span>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
    <br />
    <br />
</body>

</html>
