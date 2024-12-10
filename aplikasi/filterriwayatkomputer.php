<?php
include('../config.php');

$nomor = $_GET['id_user'];

// Query untuk mengambil data
$query = "SELECT * FROM service WHERE nomor = ?";
$params = array($nomor);
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$hasil = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if ($hasil) {
    $nomor = $hasil['nomor'];
    $tgl = $hasil['tgl'] == null ? '' : $hasil['tgl']->format('Y-m-d');
    $jam = $hasil['jam'];
    $nama = $hasil['nama'];
    $ippc = $hasil['ippc'];
    $bagian = $hasil['bagian'];
    $divisi = $hasil['divisi'];
    $kasus = $hasil['kasus'];
    $penerima = $hasil['penerima'];
    $tgl2 = $hasil['tgl2'] == null ? '' : $hasil['tgl2']->format('Y-m-d');
    $svc_kat = $hasil['svc_kat'];
    $tindakan = $hasil['tindakan'];

    $data = $nomor . "&&&" . $tgl . "&&&" . $jam . "&&&" . $nama . "&&&" . $ippc . "&&&" . $bagian . "&&&" . $divisi . "&&&" . $kasus . "&&&" . $penerima . "&&&" . $tgl2 . "&&&" . $svc_kat . "&&&" . $tindakan;
    echo $data;
} else {
    echo "Data tidak ditemukan.";
}
?>
