<?php
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => true,
    'cookie_samesite' => 'Strict',
]);

include('../config.php'); // Pastikan koneksi menggunakan `sqlsrv` untuk SQL Server

if (isset($_POST['button_login'])) {
    $user = $_POST['user'];
    $pass = $_POST['password'];

    // Menggunakan prepared statement
    $query = "SELECT * FROM tuser WHERE [user] = ? AND [password] = ?";
    $params = array($user, $pass);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($stmt)) {
        $data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $pemakai = $data['user'];
        $akses = $data['akses'];

        // Regenerasi session untuk keamanan
        session_regenerate_id(true);
        $_SESSION['user'] = $pemakai;
        $_SESSION['akses'] = $akses;

        if ($akses === 'admin' || $akses === 'super admin') {
            header('Location: ../user.php?menu=homeadmin');
            exit();
        } elseif ($akses === 'user') {
            header('Location: ../pemakai.php?menu=home');
            exit();
        } elseif ($akses === 'iso') {
            header('Location: ../iso.php?menu=home');
            exit();
        } else {
            header('Location: ../index.php?stt=Mohon Maaf User / Password Keliru');
            exit();
        }
    } else {
        header('Location: ../index.php?stt=Mohon Maaf User / Password Keliru');
        exit();
    }
}
?>
