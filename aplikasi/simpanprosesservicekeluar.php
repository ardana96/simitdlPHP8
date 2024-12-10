<?php
include('../config.php'); // Pastikan file konfigurasi untuk koneksi SQL Server tersedia

if (isset($_POST['tombol'])) {
    $tgl3 = $_POST['tgl3'];
    $jam3 = $_POST['jam3'];
    $tindakan2 = $_POST['tindakan2'];
    $nomor = $_POST['nomor'];
    $status = 'Selesai';
    $ket = 'L';

    // Query update
    $query_update = "UPDATE service 
                     SET tgl3 = ?, jam3 = ?, tindakan2 = ?, status = ?, ket = ? 
                     WHERE nomor = ?";
    $params = [$tgl3, $jam3, $tindakan2, $status, $ket, $nomor];

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_update, $params);

    if ($stmt === false) {
        // Tangani kesalahan
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Kode Kesalahan: " . $error['code'] . "<br>";
            echo "Pesan Kesalahan: " . $error['message'] . "<br>";
        }
    } else {
        header("location:../user.php?menu=serviceluar&stt=Berhasil");
    }
} else {
    header("location:../user.php?menu=serviceluar&stt=Gagal");
}
?>
