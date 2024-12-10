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
    $update = sqlsrv_query($conn, $query_update, $params);

    if ($update) {
        header("Location: ../user.php?menu=service&stt=Berhasil");
    } else {
        header("Location: ../user.php?menu=service&stt=Gagal");
    }
}
?>
