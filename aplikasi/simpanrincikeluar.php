<?php
include('../config.php');

if (isset($_POST['idbarang']) && isset($_POST['no_faktur'])) {
    $kd_barang = $_POST['idbarang'];
    $no_faktur = $_POST['no_faktur'];
    $jml = $_POST['jumlah'];

    // Query untuk mendapatkan data barang
    $query = "SELECT tbarang.idbarang, tkategori.kategori, tbarang.namabarang, tbarang.stock 
              FROM tbarang 
              INNER JOIN tkategori ON tbarang.idkategori = tkategori.idkategori 
              WHERE tbarang.idbarang = ?";
    $params = array($kd_barang);

    $get_data = sqlsrv_query($conn, $query, $params);

    // Periksa apakah query berhasil
    if ($get_data === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Periksa apakah data ditemukan
    if (sqlsrv_has_rows($get_data)) {
        $data = sqlsrv_fetch_array($get_data, SQLSRV_FETCH_ASSOC);
        $idbarang = $data['idbarang'];
        $kategori = $data['kategori'];
        $namabarang = $data['namabarang'];
        $stock = $data['stock'];
        $stockbaru = $stock - $jml;

        // Query untuk memasukkan data ke tabel trincipengambilan
        $query_rinci_jual = "INSERT INTO trincipengambilan (nofaktur, idbarang, jumlah, namabarang, sesi) 
                             VALUES (?, ?, ?, ?, 'ADM')";
        $params_rinci = array($no_faktur, $idbarang, $jml, $namabarang);

        $insert_rinci_jual = sqlsrv_query($conn, $query_rinci_jual, $params_rinci);

        // Query untuk memperbarui stok barang
        $query_update = "UPDATE tbarang SET stock = ? WHERE idbarang = ?";
        $params_update = array($stockbaru, $kd_barang);

        $update = sqlsrv_query($conn, $query_update, $params_update);

        // Periksa apakah semua query berhasil
        if ($insert_rinci_jual && $update) {
            header('Location: ../user.php?menu=keluar');
        } else {
            echo "Terjadi Kesalahan, Tidak dapat melanjutkan proses";
        }
    } else {
        echo "<script type='text/javascript'> 
                alert('Kode Barang Tidak Terdaftar/Stock Habis!'); 
                document.location.href='../user.php?menu=keluar'; 
              </script>";
    }
}
?>
