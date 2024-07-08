<?php
// inisialisai var buat koneksi ke db
$host = "localhost";  
$user = "root";       
$password = ""; 
$database = "db_beasiswa_mhs";  

// buat koneksi ke db
$conn_admin = mysqli_connect($host, $user, $password, $database);

// periksa apakah koneksi berhasil atau tidak
if (!$conn_admin) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
