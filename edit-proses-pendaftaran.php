<?php
include 'koneksi.php';
session_start();

// redirect ke halaman login jika belum login
if (!isset($_SESSION['npm'])) {
    header("location: login.php");
}

$npm = $_SESSION['npm'];

// ambil data mahasiswa
$query_mahasiswa = "SELECT * FROM tb_mahasiswa WHERE NPM = '$npm'";
$result_mahasiswa = $conn->query($query_mahasiswa);
$mahasiswa = $result_mahasiswa->fetch_assoc();

$nama = $mahasiswa['nama'];

// proses pengiriman formulir
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pendaftaran = $_POST['id_pendaftaran'];
    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $semester = $_POST['semester'];
    $upload_berkas = $_FILES['upload_berkas']['name'];

    // periksa apakah pengguna mengunggah file baru
    if (!empty($upload_berkas)) {
        // pengunggahan file
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['upload_berkas']['name']);
        move_uploaded_file($_FILES['upload_berkas']['tmp_name'], $target_file);

        // perbarui data di tb_pendaftaran_beasiswa dengan file baru dan dirtektorinya
        $upload_berkas_path = "uploads/" . $upload_berkas;
        $query_update = "UPDATE tb_pendaftaran_beasiswa SET nama = '$nama', email = '$email', no_hp = '$no_hp', semester = '$semester', upload_berkas = '$upload_berkas_path' WHERE id_pendaftaran = '$id_pendaftaran'";
    } else {
        // perbarui data di tb_pendaftaran_beasiswa tanpa mengubah file yang ada
        $query_update = "UPDATE tb_pendaftaran_beasiswa SET nama = '$nama', no_hp = '$no_hp', semester = '$semester' WHERE id_pendaftaran = '$id_pendaftaran'";
    }

    $result_update = $conn->query($query_update);

    header("location: hasil-beasiswa.php");
}
?>
