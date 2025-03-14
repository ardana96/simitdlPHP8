<?php
// Sertakan file konfigurasi database (misalnya config.php)
include(dirname(dirname(dirname(__FILE__))) . '/config.php');

// Pastikan koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

// Ambil ID item dari permintaan POST
$id_item = $_POST['id_item'] ?? ''; // Gunakan null coalescing untuk mencegah undefined index

// Validasi input
if (empty($id_item)) {
    die(json_encode(['error' => 'ID item tidak valid.']));
}

// Hapus item berdasarkan ID dengan prepared statement
$query = "DELETE FROM tipe_perawatan_item WHERE id = ?";
$params = [$id_item];
$stmt = sqlsrv_prepare($conn, $query, $params);

if ($stmt === false) {
    die("Persiapan query delete gagal: " . print_r(sqlsrv_errors(), true));
}

if (sqlsrv_execute($stmt)) {
    echo 'success';
} else {
    echo 'error';
}

// Bebaskan resource statement
sqlsrv_free_stmt($stmt);

// Tutup koneksi
sqlsrv_close($conn);
?>