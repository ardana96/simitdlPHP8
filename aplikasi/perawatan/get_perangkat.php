<?php
// Konfigurasi koneksi SQL Server
include('../../config.php');

$id = $_GET['id'];

// Query untuk mendapatkan data perangkat utama
$query = "SELECT * FROM tipe_perawatan WHERE id = ?";
$params = array($id); // Menyiapkan parameter untuk query
$stmt = sqlsrv_query($conn, $query, $params);

// Memeriksa apakah query berhasil
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Mengambil hasil perangkat utama
$perangkat = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

// Query untuk mendapatkan data item terkait perangkat
$queryItems = "SELECT * FROM tipe_perawatan_item WHERE tipe_perawatan_id = ?";
$stmtItems = sqlsrv_query($conn, $queryItems, $params);

// Memeriksa apakah queryItems berhasil
if ($stmtItems === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Membuat array untuk menyimpan data item
$items = array(); 
while ($item = sqlsrv_fetch_array($stmtItems, SQLSRV_FETCH_ASSOC)) {
    $items[] = $item;
}

// Gabungkan data perangkat dan item dalam satu array
$response = array (
    'perangkat' => $perangkat,
    'items' => $items
);

// Ubah array menjadi format JSON dan kirim sebagai respons
echo json_encode($response);

// Tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_free_stmt($stmtItems);
sqlsrv_close($conn);

?>
