<?php
// include file koneksi.php buat menghubungkan ke db
include 'koneksi.php';

// mulai sesi buat menyimpan data user yang udah login
session_start();

// prosedur buat memeriksa apakah user sudah login
function cekLogin() {
    if (!isset($_SESSION['npm'])) {
        header("location: login.php");
        exit;
    }
}

// prosedur buat memeriksa ipk user
function cekIPK($conn, $ipk) {
    if ($ipk < 3) {
        header("location: index.php");
        exit;
    }
}

// fungsi buat menyimpan data pendaftaran beasiswa ke db
function simpanPendaftaran($conn, $npm, $nama, $email, $no_hp, $semester, $ipk, $pilihan_beasiswa, $upload_berkas) {
    $nama_berkas = $upload_berkas['name'];
    $lokasi_berkas = "uploads/" . $nama_berkas;

    move_uploaded_file($upload_berkas['tmp_name'], $lokasi_berkas);

    $status_ajuan = 'Belum Diverifikasi';

    $query_simpan = "INSERT INTO tb_pendaftaran_beasiswa (npm, nama, email, no_hp, semester, ipk_terakhir, pilihan_beasiswa, upload_berkas, status_ajuan) VALUES ('$npm', '$nama', '$email', '$no_hp', $semester, $ipk, $pilihan_beasiswa, '$lokasi_berkas', '$status_ajuan')";
    $result_simpan = $conn->query($query_simpan);

    return $result_simpan;
}

// fugsi buat memproses pendaftaran beasiswa
function prosesPendaftaranBeasiswa($conn) {
    // panggil fungsi CekLogin
    cekLogin();

    // mendapatkan npm dari sesi
    $npm = $_SESSION['npm'];

    // query buat mendapatkan data mahasiswa berdasarkan npm
    $query_mahasiswa = "SELECT * FROM tb_mahasiswa WHERE NPM = '$npm'";
    $result_mahasiswa = $conn->query($query_mahasiswa);
    $mahasiswa = $result_mahasiswa->fetch_assoc();

    // mendapatkan ipk mahasiswa
    $ipk = $mahasiswa['ipk'];

    // perikasa ipk
    cekIPK($conn, $ipk);

    // mendapatkan data dari form pendaftaran
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $semester = $_POST['semester'];
    $pilihan_beasiswa = $_POST['pilihan_beasiswa'];
    $upload_berkas = $_FILES['upload_berkas'];

    // menyimpan pendaftaran ke db
    $result_simpan = simpanPendaftaran($conn, $npm, $nama, $email, $no_hp, $semester, $ipk, $pilihan_beasiswa, $upload_berkas);

    // redirect ke halaman hasil-beasiswa.php setelah pendaftaran selesai
    header("location: hasil-beasiswa.php");
    exit;
}

prosesPendaftaranBeasiswa($conn);
?>
