<?php
include('../config.php');

// Ambil data dari parameter GET
$idkategori = $_GET['idkategori'];

// Query dengan parameterized statement untuk mencegah SQL Injection
$query = "SELECT * FROM tkategori WHERE idkategori = ?";
$params = array($idkategori);
$stmt = sqlsrv_query($conn, $query, $params);

// Periksa apakah query berhasil
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Periksa apakah data ditemukan
if (sqlsrv_has_rows($stmt)) {
    $hasil = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $idkategori = $hasil['idkategori'];
    $kategori = $hasil['kategori'];

    // Gabungkan data dengan format tertentu
    $data = $idkategori . "&&&" . $kategori;
    echo $data;
} else {
    echo "Data tidak ditemukan";
}

// Bebaskan resource statement
sqlsrv_free_stmt($stmt);

// Tutup koneksi (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);

?>