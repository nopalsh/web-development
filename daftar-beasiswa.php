<html>
<head>
    <title>Daftar Beasiswa</title>
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
    }

    // ambil npm dari sesi
    $npm = $_SESSION['npm'];

    // query buat mendapatkan data mahasiswa berdasarkan npm
    $query_mahasiswa = "SELECT * FROM tb_mahasiswa WHERE NPM = '$npm'";
    $result_mahasiswa = $conn->query($query_mahasiswa);
    $mahasiswa = $result_mahasiswa->fetch_assoc();

    // ambil ipk dan nama mahasiswa
    $ipk = $mahasiswa['ipk'];
    $nama = $mahasiswa['nama'];
    $npm = $mahasiswa['npm'];

    // tentuin status ipk (aktif atau nonaktif)
    $status_ipk = ($ipk >= 3) ? "aktif" : "nonaktif";

    // tampilkan warning kalau ipk kurang dari 3.0
    $ipk_warning = ($ipk < 3) ? '<p style="color: red;">IPK kamu kurang dari 3.0</p>' : '';

    // query buat mendapatkan daftar beasiswa
    $query_beasiswa = "SELECT * FROM tb_beasiswa";
    $result_beasiswa = $conn->query($query_beasiswa);
	
$query_cek_pendaftaran = "SELECT * FROM tb_pendaftaran_beasiswa WHERE npm = '$npm'";
$result_cek_pendaftaran = $conn->query($query_cek_pendaftaran);

// kondisi untuk mahasiswa yang belum daftar
if ($result_cek_pendaftaran->num_rows > 0) {
}
?>
	<!-- konten utama -->
    <div class="konten">
        <div class="tengah">
            <h2 class="text-center"> Form Pendaftaran </h2>

            <form action="proses-daftar-beasiswa.php" method="post" enctype="multipart/form-data">
                <table>
                    
					<tr>
                        <td style="width: auto;" hidden><i class="fas fa-user"></i></td>
                        <td><label for="npm" hidden>NPM </label></td>
                        <td><input type="text" name="npm" placeholder="NPM" value="<?php echo $npm; ?>" required disabled hidden><br></td>
                    </tr>
					
                    <tr>
                        <td style="width: auto;"><i class="fas fa-user"></i></td>
                        <td><label for="nama">Masukan Nama</label></td>
                        <td><input type="text" name="nama" placeholder="Nama Lengkap" value="" required><br></td>
                    </tr>
					

                    <!-- input email -->
                    <tr>
                        <td style="width: auto;"><i class="fas fa-envelope"></i></td>
                        <td><label for="email">Masukan Email</i></label></td>
                        <td><input type="email" placeholder="email@mail.com" name="email" required><br></td>
                    </tr>
                    <!-- input nomor hp -->
                    <tr>
                        <td style="width: auto;"><i class="fas fa-phone"></i></td>
                        <td><label for="no_hp">Nomor HP</i></label></td>
                        <td><input type="tel" placeholder="08123456789" name="no_hp" pattern="[0-9]+" required><br></td>
                    </tr>
                    <!-- input semester -->
                    <tr>
                        <td style="width: auto;"><i class="fas fa-graduation-cap"></i></td>
                        <td><label for="semester">Semester Saat Ini</i></label></td>
                        <td>
                            <select name="semester" required>
                                <?php
                                for ($i = 1; $i <= 8; $i++) {
                                    echo "<option value=\"$i\">Semester $i</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <!-- input ipk -->
                    <tr>
                        <td style="width: auto;"><i class="fas fa-graduation-cap"></i></td>
                        <td><label for="ipk">IPK Terakhir</i></label></td>
                        <td><input type="text" class="input-field" name="ipk" value="<?php echo $ipk; ?>" readonly disabled><br></td>
                    </tr>
                    <!-- input pilihan beasiswa -->
                    <tr>
                        <td style="width: auto;"><i class="fas fa-award"></i></td>
                        <td><label for="pilihan_beasiswa">Pilihan Beasiswa </i></label></td>
                        <td>
                            <select name="pilihan_beasiswa" <?php echo ($status_ipk == 'nonaktif') ? 'disabled' : ''; ?>>
                                <?php
                                while ($row_beasiswa = $result_beasiswa->fetch_assoc()) {
                                    echo "<option value=\"" . $row_beasiswa['id_beasiswa'] . "\">" . $row_beasiswa['nama_beasiswa'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <!-- input upload berkas -->
                    <tr>
                        <td style="width: auto;"><i class="fas fa-file-upload"></i></td>
                        <td><label for="upload_berkas">Upload Berkas Syarat (pdf/jpg/zip)</i></label></td>
                        <td><input type="file" name="upload_berkas" accept=".pdf, .jpg, .zip" <?php echo ($status_ipk == 'nonaktif') ? 'disabled' : ''; ?> required><br></td>
                    </tr>
                </table>
                <br/>
                <!-- nampilin warning ipk jika kurang dari 3.0 -->
                <?php echo $ipk_warning; ?>
                <!-- button submit buat pendaftaran -->
                <input type="submit" value="Daftar" <?php echo ($status_ipk == 'nonaktif') ? 'disabled' : ''; ?>>
                <br/>
                <!-- button batal buat kembali ke halaman pilihan beasiswa -->
                <input type="button" value="Batal" class="btn-batal" onclick="location.href='index.php';">
            </form>
		
        </div>
    </div>
    <script>
        // jika pengguna sudah mendaftar, menampilkan pesan
        var cekPendaftaran = <?php echo $result_cek_pendaftaran->num_rows > 0?>;

        if (cekPendaftaran) {
            // tampilkan pesan popup
            alert('Anda sudah mendaftar beasiswa.');
			window.location.href = 'hasil-beasiswa.php';
        }
    </script>
</body>

</html>
