<?php
// searchkartu.php (versi SQL Server untuk PHP 8)

include('config.php'); // Menggunakan koneksi SQL Server dari C:\xampp\htdocs\simitdlPHP8\config.php

// Ambil parameter dari permintaan GET (dari AJAX di suggestkartu.js)
$search = isset($_GET['search']) && $_GET['search'] != '' ? $_GET['search'] : '';

// Query untuk mencari barang berdasarkan nama barang di tabel tbarang dengan filter report='y'
$query = "SELECT namabarang FROM tbarang WHERE namabarang LIKE ? AND report = 'y' ORDER BY namabarang";
$params = ["%$search%"];

// Eksekusi query menggunakan sqlsrv
$result = sqlsrv_query($conn, $query, $params);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Output hasil dalam format yang sesuai dengan suggestkartu.js (hanya nama barang per baris)
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    echo $row['namabarang'] . "\n";
}

// Tutup koneksi (opsional, karena akan otomatis ditutup)
sqlsrv_close($conn);
?>