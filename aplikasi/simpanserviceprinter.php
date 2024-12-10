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

    // Query parameterized untuk mencegah SQL Injection
    $query_insert = "INSERT INTO service (nomor, tgl, jam, nama, bagian, divisi, perangkat, kasus, penerima, status, noprinter) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [$nomor, $tanggal, $jam, $nama, $bagian, $devisi, $perangkat, $permasalahan, $it, $status, $ippc];

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_insert, $params);

    if ($stmt) {
        // Redirect jika berhasil
        header("location:../user.php?menu=serviceprinter&stt=DATA BERHASIL DISIMPAN");
    } else {
        // Tangkap error jika query gagal
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Kode Kesalahan: " . $error[0] . "<br>";
            echo "Pesan Kesalahan: " . $error[2] . "<br>";
        }
        header("location:../user.php?menu=serviceprinter&stt=DATA GAGAL DISIMPAN");
    }
}
?>
