<html>
<head>
    <title>Login</title>
    <!-- pakai bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- pakai custom css -->
    <link href="css/style.css?v=<?php echo time() ?>" rel="stylesheet" type="text/css">
    <!-- pakai fontawesome untuk ikon -->
    <script src="https://kit.fontawesome.com/a4f6a02fea.js" crossorigin="anonymous"></script>
</head>

<body class="login">
    <div>
        <?php
        // include file koneksi.php buat menghubungkan ke db
        include 'koneksi.php';

        // mulai sesi buat menyimpan data user yang udah login
        session_start();

        // cek klaau form login telah di submit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // megnambil npm sama pw dari form
            $npm = $_POST['npm'];
            $password = $_POST['password'];

            // query mysql buat cari user berdasarkan npm dan pw
            $query = "SELECT * FROM tb_user_mahasiswa WHERE npm = '$npm' AND password = '$password'";
            $result = $conn->query($query);

            // kalau ditemuin satu baris data di tb, set sesi dan redirect ke halaman index.php
            if ($result->num_rows == 1) {
                $_SESSION['npm'] = $npm;
                header("location: index.php");
            } else {
                // jika tidak tidak ditemukan, tampilkan pesan kesalahan
                $error = "Login Gagal. Periksa NPM dan Password Anda.";
            }
        }

        ?>
        <!-- isi konten halaman login -->
        <div class="konten-login">
            <h2 class="text-center"><i class="fas fa-sign-in-alt"></i> Login</h2>
            <h5 class="text-center"></h5>
            <?php
            // menampilkan pesan error jika ada ada error login tadi
            if (isset($error)) {
                echo "<p style='color: red; text-align: center;'>$error</p>";
            }
            ?>
            <!-- form login -->
            <form method="post" action="">
                <!-- input npm dan pw -->
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" name="npm" placeholder="NPM" required><br>
                </div>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <!-- button submit buat ngirim form -->
                <input type="submit" value="Login">
            </form>
            <h5 class="text-center"><i class="fas fa-lock"></i> APPSBEA</h5>
        </div>
    </div>
</body>

</html>
