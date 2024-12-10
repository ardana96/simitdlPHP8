<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $tgl2 = $_POST['tgl2'];
    $jam2 = $_POST['jam2'];
    $luar = $_POST['luar'];
    $tindakan = 'Pengiriman Ke Luar';
    $nomor = $_POST['nomor'];
    $status = 'PROSES';

    $query_update = "UPDATE service 
                     SET tgl2 = ?, jam2 = ?, luar = ?, tindakan = ?, status = ?
                     WHERE nomor = ?";
    $params = [$tgl2, $jam2, $luar, $tindakan, $status, $nomor];

    $stmt = sqlsrv_query($conn, $query_update, $params);

    if ($stmt === false) {
        // Tangani kesalahan jika query gagal
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Kode Kesalahan: " . $error['code'] . "<br>";
            echo "Pesan Kesalahan: " . $error['message'] . "<br>";
        }
        header("location:../user.php?menu=servicelain&stt=Gagal");
    } else {
        header("location:../user.php?menu=servicelain&stt=Berhasil");
    }
}
?>
