<html>
<head>
    <title>Pilihan Beasiswa</title>
    <!-- pakai bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- pakai custom css -->
    <link href="css/style.css?v=<?php echo time() ?>" rel="stylesheet" type="text/css">
    <!-- pakai fontawesome buat ikon -->
    <script src="https://kit.fontawesome.com/a4f6a02fea.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- narbar -->
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

    // mulai sesi buat menyimpan data user yang udah login
    session_start();

    // kalau user belum login, redirect ke halaman login
    if (!isset($_SESSION['npm'])) {
        header("location: login.php");
    }

    // ambil npm dari sesi
    $npm = $_SESSION['npm'];

    // query buat mendapatkan data mahasiswa berdasarkan npm
    $query_mahasiswa = "SELECT * FROM tb_mahasiswa WHERE NPM = '$npm'";
    $result_mahasiswa = $conn->query($query_mahasiswa);
    $mahasiswa = $result_mahasiswa->fetch_assoc();

    ?>
	<!-- konten utama -->
    <div class="container">
        <div class="container mt-4 mb-4">
            <h2>Selamat Datang, <?php echo $mahasiswa['nama']; ?>!</h2>
            <br/>
            <div class="beranda">
                <div class="tengah">
                    <center><h2><i class="fas fa-award"></i> Pilihan Beasiswa</h2></center>
                    <br/>
                    <div class="d-flex flex-row">
                        <!-- card untuk beasiswa akademik -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-book"></i> &nbsp Beasiswa Akademik</h5>
                                <p class="card-text">
                                    Diberikan kepada mahasiswa yang memiliki prestasi bidang keilmuan sains dan
                                    teknologi (sertifikat/bukti kejuaraan: karya ilmiah, karya tulis) minimal menjadi juara
                                    3 tingkat nasional dan/atau internasional.
                                </p>                                
								<p class="card-text">
								<b>Syarat berkas</b>: Melampirkan bukti prestasi bidang keilmuan sains dan teknologi dengan 
								minimal meraih juara 3 tingkat nasional dan/atau internasional, seperti sertifikat 
								atau bukti kejuaraan dalam karya ilmiah atau karya tulis.
                                </p>
                                <!-- <a href="#" class="btn button-gradient"><i class="fas fa-info-circle"></i> Lihat Selengkapnya</a>  -->
                            </div>
                        </div>
                        <!-- card buat beasiswa non-akademik -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-trophy"></i>&nbsp Beasiswa Non-Akademik</h5>
                                <p class="card-text">
                                    Diberikan kepada mahasiswa yang memiliki prestasi bidang olah raga, seni dan
                                    budaya (sertifikat/bukti kejuaraan dibidang olahaga, seni dan budaya. tingkat Nasional
                                    dan/atau Internasional
                                </p><p class="card-text">
									<b>Syarat berkas</b>: 
									Melampirkan bukti prestasi dalam bidang olahraga, seni, dan budaya, berupa sertifikat atau bukti kejuaraan tingkat nasional dan/atau internasional.	
                                </p>
                               <!--  <a href="#" class="btn button-gradient"><i class="fas fa-info-circle"></i> Lihat Selengkapnya</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- script bootstrap buat responsif -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>
