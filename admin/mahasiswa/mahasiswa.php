<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Beasiswa</title>
    <!-- pakai bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- pakai custom css -->
    <link rel="stylesheet" href="../../css/style.css?v=<?php echo time() ?>">
	
</head>
<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Beasiswa</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link active" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
<?php
// include file koneksi.php buat menghubungkan ke db
include '../../koneksi.php';

?>
<div class="konten-table">
<div class="tengah">
<h2 class="text-center">Data Pendaftar Beasiswa</h2>
<table class="table table-bordered" style="max-width: 780px;  margin: 0 auto;">
            <thead>
                <tr>
                    <th>ID Pendaftaran</th>
                    <th>NPM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Semester</th>
                    <th>IPK Terakhir</th>
                    <th>Pilihan Beasiswa</th>
                    <th>Upload Berkas</th>
                    <th>Status Ajuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
				include 'koneksi-admin.php';

// mulai sesi buat menyimpan data user yang udah login
    session_start();

    // kalau user belum login, redirect ke halaman login
    if (!isset($_SESSION['user'])) {
        header("location: login.php");
    }

    // ambil npm dari sesi
    $user = $_SESSION['user'];
				
                // query untuk mendapatkan data pendaftaran beasiswa
                $query_pendaftaran = "SELECT * FROM tb_pendaftaran_beasiswa";
                $result_pendaftaran = $conn->query($query_pendaftaran);

                // menampilkan data pendaftaran beasiswa dalam tabel
                while ($pendaftaran = $result_pendaftaran->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $pendaftaran['id_pendaftaran']; ?></td>
                        <td><?php echo $pendaftaran['npm']; ?></td>
                        <td><?php echo $pendaftaran['nama']; ?></td>
                        <td><?php echo $pendaftaran['email']; ?></td>
                        <td><?php echo $pendaftaran['no_hp']; ?></td>
                        <td><?php echo $pendaftaran['semester']; ?></td>
                        <td><?php echo $pendaftaran['ipk_terakhir']; ?></td>
                        <td>
    <?php
    // Query untuk mendapatkan nama beasiswa berdasarkan id_beasiswa pada tb_pendaftaran_beasiswa
    $query_beasiswa = "SELECT nama_beasiswa FROM tb_beasiswa WHERE id_beasiswa = " . $pendaftaran['pilihan_beasiswa'];
    $result_beasiswa = $conn->query($query_beasiswa);

    // Menampilkan nama beasiswa
    if ($result_beasiswa->num_rows > 0) {
        $beasiswa = $result_beasiswa->fetch_assoc();
        echo $beasiswa['nama_beasiswa'];
    } else {
        echo "Beasiswa tidak ditemukan";
    }
    ?>
</td>

                        <td><a href="../../<?php echo $pendaftaran['upload_berkas']; ?>" target="_blank" class="link-berkas">Lihat Berkas</a></td>
                        <td><?php echo $pendaftaran['status_ajuan']; ?></td>
<td>
    <div class="dropdown-status">
        <button class="dropbtn-status">Update Status</button>
        <div class="dropdown-content-status">
            <a href="update-status.php?id=<?php echo $pendaftaran['id_pendaftaran']; ?>&status=Belum Diverifikasi">Belum Diverifikasi</a>
            <a href="update-status.php?id=<?php echo $pendaftaran['id_pendaftaran']; ?>&status=Seleksi">Seleksi</a>
            <a href="update-status.php?id=<?php echo $pendaftaran['id_pendaftaran']; ?>&status=Lolos">Lolos</a>
            <a href="update-status.php?id=<?php echo $pendaftaran['id_pendaftaran']; ?>&status=Berkas Salah, Harap Upload Ulang Kembali">Berkas Salah</a>
            <a href="update-status.php?id=<?php echo $pendaftaran['id_pendaftaran']; ?>&status=Tidak Lolos">Tidak Lolos</a>
        </div>
    </div>
</td>


                    </tr>
                <?php } ?>
            </tbody>
        </table>
		</div>
		</div>
		
		
		
    <div class="konten-table">
        <div class="tengah">
            <h2 class="text-center">Data Mahasiswa</h2>

<table class="table table-bordered">
<a href="tambah-mahasiswa.php" class="btn btn-primary btn-sm" style="margin: 10px;">Tambah Data</a>
    <thead>
        <tr>
            <th>NPM</th>
            <th>Nama</th>
            <th>Program Studi</th>
            <th>IPK</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // query untuk mendapatkan data mahasiswa	
        $query_mahasiswa = "SELECT * FROM tb_mahasiswa";
        $result_mahasiswa = $conn->query($query_mahasiswa);

        // menampilkan data mahasiswa dalam tabel
        while ($mahasiswa = $result_mahasiswa->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo $mahasiswa['npm']; ?></td>
                <td><?php echo $mahasiswa['nama']; ?></td>
                <td><?php echo $mahasiswa['prodi']; ?></td>
                <td><?php echo $mahasiswa['ipk']; ?></td>
                <td>
                    <!-- Tambahkan link untuk edit dan hapus -->
                    <a href="edit-mahasiswa.php?npm=<?php echo $mahasiswa['npm']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus-mahasiswa.php?npm=<?php echo $mahasiswa['npm']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

        </div>
    </div>
	        
			
			    <div class="konten-table">
        <div class="tengah">
            <h2 class="text-center">Data Akun Mahasiswa</h2>

<table class="table table-bordered">
<a href="tambah-user.php" class="btn btn-primary btn-sm" style="margin: 10px;">Tambah Data</a>
    <thead>
        <tr>
            <th>NPM</th>
            <th>Password</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // query untuk mendapatkan data mahasiswa
        $query_user= "SELECT * FROM tb_user_mahasiswa";
        $result_user = $conn->query($query_user);

        // menampilkan data mahasiswa dalam tabel
        while ($user = $result_user->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo $user['npm']; ?></td>
                <td><?php echo $user['password']; ?></td>
                <td>
                    <!-- Tambahkan link untuk edit dan hapus -->
                    <a href="edit-user.php?npm=<?php echo $user['npm']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus-user.php?npm=<?php echo $user['npm']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

        </div>
    </div>

</body>
</html>
