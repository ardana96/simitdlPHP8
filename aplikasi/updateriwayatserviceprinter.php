<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = trim($_POST['nomor']);
    $tgl = $_POST['tgl'];
    $tgl2 = $_POST['tgl2'];
    $tgl3 = $_POST['tgl3'];
    $jam = $_POST['jam'];
    $nama = $_POST['nama'];
    $bagian = $_POST['bagian'];
    $divisi = $_POST['divisi'];
    $perangkat = $_POST['perangkat'];
    $permasalahan = $_POST['permasalahan'];
    $it = $_POST['it'];

    $query_update = "
        UPDATE service 
        SET 
            tgl = ?, 
            tgl2 = ?, 
            tgl3 = ?, 
            jam = ?, 
            nama = ?, 
            bagian = ?, 
            divisi = ?, 
            perangkat = ?, 
            kasus = ?, 
            penerima = ?
        WHERE 
            nomor = ?";

    $params = array($tgl, $tgl2, $tgl3, $jam, $nama, $bagian, $divisi, $perangkat, $permasalahan, $it, $nomor);

    $stmt = sqlsrv_query($conn, $query_update, $params);

    if ($stmt) {
        header("Location: ../user.php?menu=riwayatprinter&stt= Update Berhasil");
    } else {
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Kode Kesalahan: " . $error[0] . "<br>";
            echo "Pesan Kesalahan: " . $error[2] . "<br>";
        }
        header("Location: ../user.php?menu=riwayatprinter&stt=gagal");
    }
}
?>
