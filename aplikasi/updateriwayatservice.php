<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = trim($_POST['nomor']);
    $tgl = $_POST['tgl'];
    $tgl2 = $_POST['tgl2'];
    $tgl3 = $_POST['tgl3'];

    $query_update = "UPDATE service SET tgl = ?, tgl2 = ?, tgl3 = ? WHERE nomor = ?";
    $params = [$tgl, $tgl2, $tgl3, $nomor];

    $stmt = sqlsrv_query($conn, $query_update, $params);

    if ($stmt === false) {
        // Tangani kesalahan jika query gagal
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Kode Kesalahan: " . $error['code'] . "<br>";
            echo "Pesan Kesalahan: " . $error['message'] . "<br>";
        }
    } else {
        // Redirect berdasarkan keberhasilan
        header("location:../user.php?menu=riwayatsemua&stt=Update Berhasil");
    }
}
?>
