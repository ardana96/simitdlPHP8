<?php
include('../config.php'); // Pastikan koneksi menggunakan sqlsrv

$idbarang = $_GET['idbarang'];

// Query dengan parameterized statement untuk mencegah SQL Injection
$query = "SELECT * FROM tbarang WHERE idbarang = ?";
$params = array($idbarang);

// Eksekusi query
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Ambil data dari hasil query
$hasil = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if ($hasil) {
    $idbarang = $hasil['idbarang'];
    $idkategori = $hasil['idkategori'];
    $namabarang = $hasil['namabarang'];
    $barcode = $hasil['barcode'];
    $stock = $hasil['stock'];
    $inventory = $hasil['inventory'];
    $refil = $hasil['refil'];
    $stockawal = $hasil['stockawal'];
    $keterangan = $hasil['keterangan'];

    // Gabungkan data dengan format tertentu
    $data = $idbarang . "&&&" . $idkategori . "&&&" . $namabarang . "&&&" . $barcode . "&&&" . $stock . "&&&" . $inventory . "&&&" . $refil . "&&&" . $keterangan . "&&&" . $stockawal;
    echo $data;
} else {
    echo "Data tidak ditemukan untuk idbarang: " . htmlspecialchars($idbarang);
}

// Bebaskan resource statement
sqlsrv_free_stmt($stmt);

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
