<?php
// inisialisai var buat koneksi ke db
$host = "localhost";  
$user = "root";       
$password = ""; 
$database = "db_beasiswa_mhs";  

// buat koneksi ke db
$conn = mysqli_connect($host, $user, $password, $database);

// periksa apakah koneksi berhasil atau tidak
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
