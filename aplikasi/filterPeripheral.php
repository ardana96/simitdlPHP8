<?php
include('../config.php'); // Pastikan koneksi sudah benar ke SQL Server
$nomor = $_GET['nomor'];

// Query untuk mengambil data
$query = "SELECT * FROM peripheral WHERE nomor = ?";
$params = array($nomor);

// Eksekusi query menggunakan sqlsrv_query
$stmt = sqlsrv_query($conn, $query, $params);

// Periksa apakah data ditemukan
if ($stmt === false) {
    // Jika gagal, tangkap error dan tampilkan
    die(print_r(sqlsrv_errors(), true));
} else {
    // Ambil hasil query menggunakan sqlsrv_fetch_array
    $hasil = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    // Ambil data dari hasil query
    $nomor = $hasil['nomor'];
    $id_perangkat = $hasil['id_perangkat'];
    $perangkat = $hasil['perangkat'];
    $keterangan = $hasil['keterangan'];
    $divisi = $hasil['divisi'];
    $user = $hasil['user'];
    $lokasi = $hasil['lokasi'];
    $tgl_perawatan = $hasil['tgl_perawatan'];
    $bulan = $hasil['bulan'];
    $tipe = $hasil['tipe'];
    $brand = $hasil['brand'];
    $model = $hasil['model'];
    $pembelian_dari = $hasil['pembelian_dari'];
    $sn = $hasil['sn'];

    // Gabungkan data menjadi string yang dipisahkan oleh '&&&'
    $data = $nomor . "&&&" . $id_perangkat . "&&&" . $perangkat . "&&&" . $keterangan . "&&&" . $divisi . "&&&" . $user . "&&&" . $lokasi . "&&&" . $tgl_perawatan->format('Y-m-d') . "&&&" . $bulan . "&&&" . $tipe . "&&&" . $brand . "&&&" . $model . "&&&" . $pembelian_dari . "&&&" . $sn;

    // Tampilkan data
    echo $data;
}

// Bebaskan resource statement
sqlsrv_free_stmt($stmt);
?>
