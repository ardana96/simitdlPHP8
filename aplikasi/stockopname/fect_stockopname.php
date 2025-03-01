<?php
include('../../config.php'); // Pastikan path config.php benar

// Validasi koneksi database
if ($conn === false) {
    header('Content-Type: application/json');
    die(json_encode([
        "error" => "Koneksi database gagal",
        "details" => sqlsrv_errors()
    ]));
}

// Ambil halaman dan limit dari request, default halaman pertama (1) dan limit 10
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Default 10 jika tidak ada limit
$offset = ($page - 1) * $limit; // Mulai dari row ke-berapa

// Query dengan pagination menggunakan ROW_NUMBER dan ORDER BY id ASC
$sql = "SELECT * FROM (
    SELECT ROW_NUMBER() OVER (ORDER BY id ASC) AS RowNum, 
           nomor, ippc, idpc, [user], namapc, bagian, subbagian, lokasi, prosesor, mobo, ram, harddisk, bulan, tgl_perawatan, tgl_update
    FROM pcaktif
) AS RowConstrainedResult
WHERE RowNum > ? AND RowNum <= ?";
$params = array($offset, $offset + $limit);
$query = sqlsrv_query($conn, $sql, $params);

// Periksa apakah query berhasil
if ($query === false) {
    header('Content-Type: application/json');
    die(json_encode([
        "error" => "Query utama gagal",
        "sql" => $sql,
        "params" => $params,
        "details" => sqlsrv_errors()
    ]));
}

// Ambil data
$data = [];
while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    // Format tanggal jika ada
    if (isset($row['tgl_perawatan']) && $row['tgl_perawatan'] instanceof DateTime) {
        $row['tgl_perawatan'] = $row['tgl_perawatan']->format('Y-m-d');
    }
    if (isset($row['tgl_update']) && $row['tgl_update'] instanceof DateTime) {
        $row['tgl_update'] = $row['tgl_update']->format('Y-m-d');
    }

    // Ambil nama bulan dari tabel bulan
    $bulanQuery = sqlsrv_query($conn, "SELECT bulan FROM bulan WHERE id_bulan = ?", array($row['bulan']));
    if ($bulanQuery === false) {
        $row['bulan'] = "Error: " . print_r(sqlsrv_errors(), true);
    } elseif ($bulanData = sqlsrv_fetch_array($bulanQuery, SQLSRV_FETCH_ASSOC)) {
        $row['bulan'] = $bulanData['bulan'];
    } else {
        $row['bulan'] = "Tidak Diketahui";
    }

    $data[] = $row;
}

// Bebaskan resource query
sqlsrv_free_stmt($query);

// Hitung total data untuk pagination
$countQuery = sqlsrv_query($conn, "SELECT COUNT(*) as total FROM pcaktif");
if ($countQuery === false) {
    header('Content-Type: application/json');
    die(json_encode([
        "error" => "Query count gagal",
        "details" => sqlsrv_errors()
    ]));
}

$totalData = sqlsrv_fetch_array($countQuery, SQLSRV_FETCH_ASSOC);
$totalPages = ceil($totalData['total'] / $limit);

// Bebaskan resource count query
sqlsrv_free_stmt($countQuery);

// Kirim response JSON
header('Content-Type: application/json');
echo json_encode([
    "data" => $data,
    "totalPages" => $totalPages,
    "currentPage" => $page,
    "status" => "success"
]);
?>