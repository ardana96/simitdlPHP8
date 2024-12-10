<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = $_POST['nomor'];
    $tanggal = $_POST['tgl'];
    $jam = $_POST['jam'];
    $bagian = $_POST['bagian'];
    $devisi = $_POST['devisi'];
    $perangkat = $_POST['perangkat'];
    $permasalahan = $_POST['permasalahan'];
    $it = $_POST['it'];
    $nama = $_POST['nama'];
    $status = $_POST['status'];
    $ippc = $_POST['ippc'];

    $query_insert = "INSERT INTO service (nomor, tgl, jam, nama, bagian, divisi, perangkat, kasus, penerima, status, ippc) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                     
    $params = [
        $nomor,
        $tanggal,
        $jam,
        $nama,
        $bagian,
        $devisi,
        $perangkat,
        $permasalahan,
        $it,
        $status,
        $ippc
    ];

    $stmt = sqlsrv_query($conn, $query_insert, $params);

    if ($stmt === false) {
        // Tangani kesalahan jika query gagal
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Kode Kesalahan: " . $error['code'] . "<br>";
            echo "Pesan Kesalahan: " . $error['message'] . "<br>";
        }
    } else {
        header("location:../user.php?menu=servicelain&stt=DATA BERHASIL DISIMPAN");
    }
}
?>
