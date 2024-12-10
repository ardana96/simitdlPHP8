<?php
include('../config.php');

$nomor = $_GET['nomor'];
$query = "SELECT * FROM service WHERE nomor = ?";
$params = array($nomor);
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    // Tangani kesalahan
    $errors = sqlsrv_errors();
    foreach ($errors as $error) {
        echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
        echo "Kode Kesalahan: " . $error['code'] . "<br>";
        echo "Pesan Kesalahan: " . $error['message'] . "<br>";
    }
} else {
    $hasil = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($hasil) {
        $tgl2 = $hasil['tgl2'] ? $hasil['tgl2']->format('Y-m-d') : '';
        $nomor = $hasil['nomor'];
        $nama = $hasil['nama'];
        $bag = $hasil['bagian'];
        $divisi = $hasil['divisi'];
        $perangkat = $hasil['perangkat'];
        $kasus = $hasil['kasus'];
        $penerima = $hasil['penerima'];

        $data = $nomor . "&&&" . $tgl2 . "&&&" . $nama . "&&&" . $bag . "&&&" . $divisi . "&&&" . $perangkat . "&&&" . $kasus . "&&&" . $penerima;
        echo $data;
    } else {
        echo "Data tidak ditemukan.";
    }
}
?>
