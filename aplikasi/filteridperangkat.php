<?php
include('../config.php');

// Ambil parameter dari URL
$keterangan = $_GET['keterangan'];

// Query dengan parameterized untuk mencegah SQL Injection
$query = "SELECT * FROM printer WHERE keterangan = ?";
$params = [$keterangan];

// Eksekusi query
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    // Tangkap error jika query gagal
    $errors = sqlsrv_errors();
    foreach ($errors as $error) {
        echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
        echo "Kode Kesalahan: " . $error[0] . "<br>";
        echo "Pesan Kesalahan: " . $error[2] . "<br>";
    }
    die("Query gagal dijalankan.");
}

// Fetch hasil query
$hasil = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if ($hasil) {
    $id_perangkat = $hasil['id_perangkat'];
    $bagian = $hasil['keterangan'];
    $divisi = $hasil['status'];
    $printer = $hasil['printer'];

    // Gabungkan data ke dalam string
    $data = $bagian . "&&&" . $divisi . "&&&" . $printer . "&&&" . $keterangan;
    echo $data;
} else {
    echo "Data tidak ditemukan.";
}
?>
