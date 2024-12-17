<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = trim($_POST['nomor']);
    $status = $_POST['status'];
    $ket = $_POST['ket'];
    $qty = $_POST['qty'];
    $keterangan = $_POST['keterangan'];

    $tgl = $_POST['tgl'];
    $nama = $_POST['nama'];
    $bagian = $_POST['bagian'];
    $divisi = $_POST['divisi'];
    $namabarang = $_POST['namabarang'];

    // Query update
    $query_update = "UPDATE permintaan 
                     SET tgl = ?, nama = ?, bagian = ?, divisi = ?, namabarang = ?, qty = ?, status = ?, keterangan = ?, ket = ? 
                     WHERE nomor = ?";
                     
    // Parameter untuk query
    $params = [$tgl, $nama, $bagian, $divisi, $namabarang, $qty, $status, $keterangan, $ket, $nomor];
    
    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_update, $params);

    if ($stmt) {
        header("location:../user.php?menu=permintaan&stt= Update Berhasil");
    } else {
        // Menampilkan pesan error jika query gagal
        echo "Error in query preparation/execution: ";
        die(print_r(sqlsrv_errors(), true));
    }
}
?>
