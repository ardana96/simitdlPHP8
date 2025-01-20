<?php
// session_start();
// unset($_SESSION['user']); unset($_SESSION['akses']);
// session_destroy(); header('location:../index.php');
?>
<?php
session_start();
include('../config.php'); // Pastikan koneksi ke SQL Server

// 🔹 Hapus session dari database jika ada session_token
if (isset($_COOKIE['session_token'])) {
    $sql = "UPDATE tuser SET session_token = NULL WHERE session_token = ?";
    sqlsrv_query($conn, $sql, array($_COOKIE['session_token']));

    // 🔹 Hapus cookie session agar user benar-benar logout
    setcookie("session_token", "", time() - 3600, "/", "", false, true);
}

// 🔹 Hapus session dari PHP
unset($_SESSION['user']);
unset($_SESSION['akses']);
session_destroy();

// 🔹 Redirect kembali ke halaman login
header("Location: ../index.php");
exit();
?>
