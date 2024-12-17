<?php
include('../config.php');

$nomor = $_GET['nomor'];

// Query untuk mendapatkan data dari tabel permintaan
$query = "SELECT * FROM permintaan WHERE nomor = ?";
$params = [$nomor];
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true)); // Error handling jika query gagal
}

$hasil = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if ($hasil) {
    $nomor = $hasil['nomor'];
    $nama = $hasil['nama'];
    $status = $hasil['status'];
    $ket = $hasil['ket'];
    $qty = $hasil['qty'];
    $keterangan = $hasil['keterangan'];
    $tgl = $hasil['tgl'] ? $hasil['tgl']->format('d-m-Y') : '';
    $bagian = $hasil['bagian'];
    $divisi = $hasil['divisi'];
    $namabarang = $hasil['namabarang'];

    $data = $nomor . "&&&" . $status . "&&&" . $ket . "&&&" . $keterangan . "&&&" . $qty . "&&&" . $tgl . "&&&" . $bagian . "&&&" . $divisi . "&&&" . $namabarang . "&&&" . $nama;
    echo $data;
} else {
    echo "Data tidak ditemukan.";
}
?>
