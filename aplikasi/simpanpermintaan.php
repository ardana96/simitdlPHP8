<?php
include('../config.php');
if (isset($_POST['tombol'])) {
    $nomor = $_POST['nomor'];
    $tgl = $_POST['tgl'];
    $nama = $_POST['nama'];
    $bagian = $_POST['bagian'];
    $divisi = $_POST['divisi'];
    $namabarang = $_POST['namabarang'];
    $qty = $_POST['qty'];
    $keterangan = $_POST['keterangan'];

    // Query untuk memasukkan data
    $query_insert = "INSERT INTO permintaan (nomor, tgl, nama, bagian, divisi, namabarang, qty, keterangan, status, aktif) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'PENDING', 'aktif')";

    // Parameter untuk query
    $params = [$nomor, $tgl, $nama, $bagian, $divisi, $namabarang, $qty, $keterangan];

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_insert, $params);

    // Cek hasil eksekusi
    if ($stmt) {
        header("location:../user.php?menu=permintaan&stt= Simpan Berhasil");
    } else {
        // Menampilkan kesalahan jika query gagal
        die(print_r(sqlsrv_errors(), true));
    }
}
?>
