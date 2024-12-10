<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $tgl2 = $_POST['tgl2'];
    $jam2 = $_POST['jam2'];
    $teknisi = $_POST['teknisi'];
    $tindakan = $_POST['tindakan'];
    $keterangan = $_POST['keterangan'];
    $nomor = $_POST['nomor'];
    $status = 'Selesai';
    $ket = 'D';

    // Query parameterized untuk mencegah SQL Injection
    $query_update = "UPDATE service 
                     SET keterangan = ?, tgl2 = ?, jam2 = ?, teknisi = ?, tindakan = ?, status = ?, ket = ? 
                     WHERE nomor = ?";
    $params = [$keterangan, $tgl2, $jam2, $teknisi, $tindakan, $status, $ket, $nomor];

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_update, $params);

    if ($stmt) {
        // Redirect jika berhasil
        header("location:../user.php?menu=serviceprinter&stt=Simpan Berhasil");
    } else {
        // Tangkap error jika query gagal
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Kode Kesalahan: " . $error[0] . "<br>";
            echo "Pesan Kesalahan: " . $error[2] . "<br>";
        }
        header("location:../user.php?menu=serviceprinter&stt=Gagal Simpan");
    }
}
?>
