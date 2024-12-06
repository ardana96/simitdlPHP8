<?php
include('../config.php'); // Pastikan koneksi sudah benar menggunakan SQL Server

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $nomor = $_POST['nomor'];
    $id_perangkat = $_POST['id_perangkat'];
    $perangkat = $_POST['perangkat'];
    $keterangan = $_POST['keterangan'];
    $divisi = $_POST['divisi'];
    $user = $_POST['user'];
    $lokasi = $_POST['lokasi'];
    $tgl_perawatan = $_POST['tgl_perawatan'];
    $bulan = $_POST['bulan'];
    $tipe = $_POST['tipe'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $pembelian_dari = $_POST['pembelian_dari'];
    $sn = $_POST['sn'];

    // Query update dengan parameterized query
    $query_update = "UPDATE peripheral SET 
                    id_perangkat = ?, 
                    perangkat = ?, 
                    keterangan = ?, 
                    divisi = ?, 
                    [user] = ?, 
                    lokasi = ?, 
                    tgl_perawatan = ?, 
                    bulan = ?, 
                    tipe = ?, 
                    brand = ?, 
                    model = ?, 
                    pembelian_dari = ?, 
                    sn = ? 
                    WHERE nomor = ?";

    // Parameter untuk bind ke query
    $params = array(
        $id_perangkat, 
        $perangkat, 
        $keterangan, 
        $divisi, 
        $user, 
        $lokasi, 
        $tgl_perawatan, 
        $bulan, 
        $tipe, 
        $brand, 
        $model, 
        $pembelian_dari, 
        $sn, 
        $nomor
    );

    // Eksekusi query menggunakan sqlsrv_query
    $stmt = sqlsrv_query($conn, $query_update, $params);

    // Periksa apakah query berhasil dijalankan
    if ($stmt === false) {
        // Jika gagal, tangkap error
        $errors = sqlsrv_errors();
        header("Location: ../user.php?menu=peripheral&stt=Gagal update data. Error: " . print_r($errors, true));
    } else {
        // Jika berhasil, redirect ke halaman dengan pesan sukses
        header("Location: ../user.php?menu=peripheral&stt=Update Berhasil");
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}
?>
