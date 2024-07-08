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


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Ambil nilai id dan status dari parameter URL
    $id_pendaftaran = $_GET['id'];
    $status_ajuan = $_GET['status'];

    // Update status pendaftaran
    $query_update_status = "UPDATE tb_pendaftaran_beasiswa SET status_ajuan = '$status_ajuan' WHERE id_pendaftaran = $id_pendaftaran";
    $result_update_status = $conn->query($query_update_status);

    if ($result_update_status) {
        // Redirect kembali ke halaman sebelumnya
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        echo "Gagal mengupdate status.";
    }
} else {
    echo "Metode HTTP yang digunakan bukan GET.";
}
?>
