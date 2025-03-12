<?php
// Include konfigurasi koneksi
include('../../../config.php');

header('Content-Type: application/json');

// Debugging: Tambahkan log untuk memastikan file diakses
error_log("filter_data.php diakses");

// Periksa koneksi database
if ($conn === false) {
    error_log("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
    echo json_encode(['error' => 'Koneksi database gagal: ' . print_r(sqlsrv_errors(), true)]);
    exit;
}

// Ambil data filter dari POST
$divisi = isset($_POST['divisi']) ? $_POST['divisi'] : '';
$bagian = isset($_POST['bagian']) ? $_POST['bagian'] : '';
$subBagian = isset($_POST['subBagian']) ? $_POST['subBagian'] : '';
$lokasi = isset($_POST['lokasi']) ? $_POST['lokasi'] : '';
$bulan = isset($_POST['bulan']) ? $_POST['bulan'] : ''; // id_bulan
$pcLaptop = isset($_POST['pcLaptop']) ? $_POST['pcLaptop'] : '';

// Ambil parameter pagination (opsional, jika dikirim dari frontend)
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$recordsPerPage = isset($_POST['recordsPerPage']) ? (int)$_POST['recordsPerPage'] : 10;

// Query dasar
$query = "SELECT * FROM [dbo].[pcaktif] WHERE 1=1";

// Tambahkan kondisi filter jika ada nilai
$conditions = [];
$params = [];

if (!empty($divisi)) {
    $conditions[] = "[divisi] = ?";
    $params[] = $divisi;
}
if (!empty($bagian)) {
    $conditions[] = "[bagian] = ?";
    $params[] = $bagian;
}
if (!empty($subBagian)) {
    $conditions[] = "[subBagian] = ?";
    $params[] = $subBagian;
}
if (!empty($lokasi)) {
    $conditions[] = "[lokasi] = ?";
    $params[] = $lokasi;
}
if (!empty($bulan)) {
    $conditions[] = "[bulan] = ?";
    $params[] = $bulan;
}
if (!empty($pcLaptop)) {
    $conditions[] = "[model] = ?"; // Sesuaikan dengan nama kolom model
    $params[] = $pcLaptop;
}

if (!empty($conditions)) {
    $query .= " AND " . implode(" AND ", $conditions);
}

// Hitung total data yang difilter
$totalQuery = "SELECT COUNT(*) as total FROM [dbo].[pcaktif] WHERE 1=1";
if (!empty($conditions)) {
    $totalQuery .= " AND " . implode(" AND ", $conditions);
}
$totalResult = sqlsrv_query($conn, $totalQuery, $params);
$totalRow = sqlsrv_fetch_array($totalResult, SQLSRV_FETCH_ASSOC);
$totalRecords = $totalRow['total'];


// Hitung offset untuk pagination
$offset = ($page - 1) * $recordsPerPage;

// Tambahkan LIMIT dan OFFSET untuk pagination
$query .= " ORDER BY [id] OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
$params[] = $offset;
$params[] = $recordsPerPage;

// Eksekusi query dengan parameter
$result = sqlsrv_query($conn, $query, $params);

if ($result === false) {
    error_log("Query gagal: " . print_r(sqlsrv_errors(), true));
    echo json_encode(['error' => 'Query gagal: ' . print_r(sqlsrv_errors(), true)]);
    exit;
}

$data = [];
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

// Hitung total halaman
$totalPages = ceil($totalRecords / $recordsPerPage);

error_log("Total records: $totalRecords, Total pages: $totalPages, Page: $page, Records per page: $recordsPerPage");

echo json_encode([
    'status' => 'success',
    'data' => $data,
    'totalRecords' => $totalRecords,
    'totalPages' => $totalPages,
    'currentPage' => $page,
    'recordsPerPage' => $recordsPerPage
]);

// Tutup koneksi
sqlsrv_close($conn);
?>