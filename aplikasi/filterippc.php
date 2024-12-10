<?php 
include('../config.php');

$ippc = $_GET['ippc'];
$query = "SELECT * FROM pcaktif WHERE ippc = ?";
$params = array($ippc);
$get_data = sqlsrv_query($conn, $query, $params);

if ($get_data === false) {
    die(print_r(sqlsrv_errors(), true));
}

$hasil = sqlsrv_fetch_array($get_data, SQLSRV_FETCH_ASSOC);
if ($hasil) {
    $ippc = $hasil['ippc'];
    $bagian = $hasil['bagian'];
    $divisi = $hasil['divisi'];
    $perangkat = $hasil['model'];

    $data = $bagian . "&&&" . $divisi . "&&&" . $ippc . "&&&" . $perangkat;
    echo $data;
} else {
    echo "Data tidak ditemukan.";
}
?>
