<?php
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

// Ambil ID user dari parameter URL
$npm = $_GET['npm'];

// Query untuk menghapus data user
$query_hapus_user = "DELETE FROM tb_user_mahasiswa WHERE npm = '$npm'";

if ($conn->query($query_hapus_user) === TRUE) {
    header("Location: mahasiswa.php");
} else {
    echo "Error: " . $query_hapus_user . "<br>" . $conn->error;
}
?>
