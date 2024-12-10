<?php
include('../config.php');

$nomor = $_GET['id_user'];
$query = "SELECT * FROM service WHERE nomor = ?";
$params = array($nomor);
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt !== false && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $nomor      = $row['nomor'];
    $tgl        = $row['tgl'] ? $row['tgl']->format('Y-m-d') : '';
    $jam        = $row['jam'];
    $tgl2       = $row['tgl2'] ? $row['tgl2']->format('Y-m-d') : '';
    $tgl3       = $row['tgl3'] ? $row['tgl3']->format('Y-m-d') : '';
    $nama       = $row['nama'];
    $bagian     = $row['bagian'];
    $divisi     = $row['divisi'];
    $perangkat  = $row['perangkat'];
    $kasus      = $row['kasus'];
    $penerima   = $row['penerima'];

    $data = $nomor . "&&&" . $jam . "&&&" . $tgl . "&&&" . $tgl2 . "&&&" . $tgl3 . "&&&" . $nama . "&&&" . $bagian . "&&&" . $divisi . "&&&" . $perangkat . "&&&" . $kasus . "&&&" . $penerima;
    echo $data;
} else {
    // Menampilkan error jika query gagal
    $errors = sqlsrv_errors();
    foreach ($errors as $error) {
        echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
        echo "Kode Kesalahan: " . $error[0] . "<br>";
        echo "Pesan Kesalahan: " . $error[2] . "<br>";
    }
}
?>
