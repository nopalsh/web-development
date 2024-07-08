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

// cek apakah parameter npm ada dalam URL
if (isset($_GET['npm'])) {
    $npm = $_GET['npm'];

    // query hapus data mahasiswa
    $query_hapus = "DELETE FROM tb_mahasiswa WHERE npm = '$npm'";
    $result_hapus = $conn->query($query_hapus);

    if ($result_hapus) {
        // redirect ke halaman mahasiswa.php setelah berhasil hapus
        header("Location: mahasiswa.php");
        exit();
    } else {
        // handle error hapus, misalnya tampilkan pesan error
        $error_message = "Error deleting record: " . $conn->error;
    }
} else {
    // jika parameter npm tidak ada, redirect ke halaman utama atau berikan pesan error
    header("Location: mahasiswa.php");
    exit();
}

// Tutup koneksi database
$conn->close();
?>
