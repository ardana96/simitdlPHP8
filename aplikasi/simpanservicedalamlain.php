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

    $query_update = "UPDATE service 
                     SET keterangan = ?, tgl2 = ?, jam2 = ?, teknisi = ?, tindakan = ?, status = ?, ket = ?
                     WHERE nomor = ?";
    $params = [$keterangan, $tgl2, $jam2, $teknisi, $tindakan, $status, $ket, $nomor];

    $stmt = sqlsrv_query($conn, $query_update, $params);

    if ($stmt === false) {
        // Tangani kesalahan jika query gagal
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Kode Kesalahan: " . $error['code'] . "<br>";
            echo "Pesan Kesalahan: " . $error['message'] . "<br>";
        }
        header("location:../user.php?menu=servicelain&stt=Gagal Simpan");
    } else {
        header("location:../user.php?menu=servicelain&stt=Simpan Berhasil");
    }
}
?>
