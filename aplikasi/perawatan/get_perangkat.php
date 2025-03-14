<?php
// Sertakan file konfigurasi database (misalnya config.php)
include(dirname(dirname(dirname(__FILE__))) . '/config.php');

// Pastikan koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

// Ambil ID dari parameter GET
$id = $_GET['id'] ?? ''; // Gunakan null coalescing untuk mencegah undefined index

// Validasi ID
if (empty($id)) {
    die(json_encode(['error' => 'ID tidak valid.']));
}

// Query untuk mendapatkan data perangkat utama
$query = "SELECT * FROM tipe_perawatan WHERE id = ?";
$params = [$id];
$stmt = sqlsrv_prepare($conn, $query, $params);

if ($stmt === false) {
    die("Persiapan query tipe_perawatan gagal: " . print_r(sqlsrv_errors(), true));
}

if (!sqlsrv_execute($stmt)) {
    die("Eksekusi query tipe_perawatan gagal: " . print_r(sqlsrv_errors(), true));
}

// Ambil data perangkat
$perangkat = null;
if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $perangkat = $row;
}
sqlsrv_free_stmt($stmt);

// Query untuk mendapatkan data item terkait perangkat
$queryItems = "SELECT * FROM tipe_perawatan_item WHERE tipe_perawatan_id = ?";
$paramsItems = [$id];
$stmtItems = sqlsrv_prepare($conn, $queryItems, $paramsItems);

if ($stmtItems === false) {
    die("Persiapan query tipe_perawatan_item gagal: " . print_r(sqlsrv_errors(), true));
}

if (!sqlsrv_execute($stmtItems)) {
    die("Eksekusi query tipe_perawatan_item gagal: " . print_r(sqlsrv_errors(), true));
}

// Ambil data items
$items = [];
while ($item = sqlsrv_fetch_array($stmtItems, SQLSRV_FETCH_ASSOC)) {
    // Konversi tipe data jika ada (misalnya, tanggal)
    foreach ($item as $key => $value) {
        if ($value instanceof DateTime) {
            $item[$key] = $value->format('Y-m-d H:i:s');
        }
    }
    $items[] = $item;
}
sqlsrv_free_stmt($stmtItems);

// Gabungkan data perangkat dan item dalam satu array
$response = [
    'perangkat' => $perangkat ?: new stdClass(), // Gunakan object kosong jika null
    'items' => $items
];

// Ubah array menjadi format JSON dan kirim sebagai respons
echo json_encode($response);

// Tutup koneksi
sqlsrv_close($conn);
?>