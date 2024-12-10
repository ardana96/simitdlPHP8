<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $tgl2 = $_POST['tgl2'];
    $jam2 = $_POST['jam2'];
    $luar = $_POST['luar'];
    $tindakan = 'Pengiriman Ke Luar';
    $nomor = $_POST['nomor'];
    $status = 'PROSES';

    // Query parameterized untuk mencegah SQL Injection
    $query_update = "UPDATE service 
                     SET tgl2 = ?, jam2 = ?, luar = ?, tindakan = ?, status = ? 
                     WHERE nomor = ?";
    $params = [$tgl2, $jam2, $luar, $tindakan, $status, $nomor];

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_update, $params);

    if ($stmt) {
        // Redirect jika berhasil
        header("location:../user.php?menu=serviceprinter&stt=Berhasil");
    } else {
        // Tangkap error jika query gagal
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Kode Kesalahan: " . $error[0] . "<br>";
            echo "Pesan Kesalahan: " . $error[2] . "<br>";
        }
        header("location:../user.php?menu=serviceprinter&stt=Gagal");
    }
}
?>
