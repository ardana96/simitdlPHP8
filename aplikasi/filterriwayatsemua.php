<?php
include('../config.php');

$nomor = $_GET['id_user'];
$query = "SELECT * FROM service WHERE nomor = ?";
$params = [$nomor];
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    // Tangani kesalahan jika query gagal
    $errors = sqlsrv_errors();
    foreach ($errors as $error) {
        echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
        echo "Kode Kesalahan: " . $error['code'] . "<br>";
        echo "Pesan Kesalahan: " . $error['message'] . "<br>";
    }
} else {
    $hasil = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($hasil) {
        $tgl = $hasil['tgl'] ? $hasil['tgl']->format('Y-m-d') : '';
        $tgl2 = $hasil['tgl2'] ? $hasil['tgl2']->format('Y-m-d') : '';
        $tgl3 = $hasil['tgl3'] ? $hasil['tgl3']->format('Y-m-d') : '';
        $nomor = $hasil['nomor'];

        $data = $tgl . "&&&" . $tgl2 . "&&&" . $tgl3 . "&&&" . $nomor;
        echo $data;
    } else {
        echo "Data tidak ditemukan.";
    }
}
?>
