<?php
include('../config.php'); // Pastikan koneksi menggunakan sqlsrv

$idsupp = $_GET['idsupp'];

// Gunakan prepared statement untuk menghindari SQL Injection
$query = "SELECT * FROM tsupplier WHERE idsupp = ?";
$params = array($idsupp);
$stmt = sqlsrv_query($conn, $query, $params);

// Periksa apakah query berhasil
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Periksa apakah data ditemukan
if (sqlsrv_has_rows($stmt)) {
    $hasil = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $idsupp = $hasil['idsupp'];
    $namasupp = $hasil['namasupp'];
    $alamatsupp = $hasil['alamatsupp'];
    $telpsupp = $hasil['telpsupp'];

    // Gabungkan data menggunakan format tertentu
    $data = $namasupp . "&&&" . $alamatsupp . "&&&" . $telpsupp . "&&&" . $idsupp;
    echo $data;
} else {
    echo "Data tidak ditemukan";
}

// Bebaskan statement
sqlsrv_free_stmt($stmt);

// Tutup koneksi (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
