<?php
// Sesuaikan path inklusi config.php ke root proyek
include(dirname(dirname(dirname(__FILE__))) . '/config.php');

// Validasi koneksi database
if ($conn === false) {
    header('Content-Type: application/json');
    die(json_encode([
        "status" => "error",
        "message" => "Koneksi database gagal",
        "details" => sqlsrv_errors()
    ]));
}

// Ambil parameter dari request GET dengan sanitasi dan default value
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0 ? (int)$_GET['limit'] : 10;

// Validasi batasan limit (misalnya maksimum 250 untuk mencegah beban berlebih)
$limit = min($limit, 250);

// Hitung offset untuk pagination
$offset = ($page - 1) * $limit;

// Query utama dengan pagination menggunakan ROW_NUMBER
$sql = "SELECT * FROM (
    SELECT ROW_NUMBER() OVER (ORDER BY id ASC) AS RowNum, 
           id, nomor, ippc, idpc, [user], namapc, bagian, subbagian, lokasi, prosesor, mobo, ram, harddisk, bulan, tgl_perawatan, tgl_update, isDeleted
    FROM pcaktif where isDeleted = 0
) AS RowConstrainedResult
WHERE RowNum > ? AND RowNum <= ?";
$params = [$offset, $offset + $limit];
$query = sqlsrv_query($conn, $sql, $params);

// Periksa apakah query utama berhasil
if ($query === false) {
    header('Content-Type: application/json');
    die(json_encode([
        "status" => "error",
        "message" => "Gagal menjalankan query utama",
        "sql" => $sql,
        "params" => $params,
        "details" => sqlsrv_errors()
    ]));
}

// Ambil data dan format tanggal serta nama bulan
$data = [];
while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    // Format tanggal jika ada
    if (isset($row['tgl_perawatan']) && $row['tgl_perawatan'] instanceof DateTime) {
        $row['tgl_perawatan'] = $row['tgl_perawatan']->format('Y-m-d');
    } elseif (isset($row['tgl_perawatan'])) {
        $row['tgl_perawatan'] = ''; // Default jika bukan DateTime
    }

    if (isset($row['tgl_update']) && $row['tgl_update'] instanceof DateTime) {
        $row['tgl_update'] = $row['tgl_update']->format('Y-m-d');
    } elseif (isset($row['tgl_update'])) {
        $row['tgl_update'] = ''; // Default jika bukan DateTime
    }

    // Ambil nama bulan dari tabel bulan
    if (isset($row['bulan'])) {
        $bulanQuery = sqlsrv_query($conn, "SELECT bulan FROM bulan WHERE id_bulan = ?", [$row['bulan']]);
        if ($bulanQuery === false) {
            $row['bulan'] = "Error: " . print_r(sqlsrv_errors(), true);
        } elseif ($bulanData = sqlsrv_fetch_array($bulanQuery, SQLSRV_FETCH_ASSOC)) {
            $row['bulan'] = $bulanData['bulan'];
        } else {
            $row['bulan'] = "Tidak Diketahui";
        }
        sqlsrv_free_stmt($bulanQuery); // Bebaskan resource
    }

    $data[] = $row;
}

// Bebaskan resource query utama
sqlsrv_free_stmt($query);

// Hitung total data untuk pagination
$countQuery = sqlsrv_query($conn, "SELECT COUNT(*) as total FROM pcaktif");
if ($countQuery === false) {
    header('Content-Type: application/json');
    die(json_encode([
        "status" => "error",
        "message" => "Gagal menghitung total data",
        "details" => sqlsrv_errors()
    ]));
}

$totalData = sqlsrv_fetch_array($countQuery, SQLSRV_FETCH_ASSOC);
$totalPages = ceil($totalData['total'] / $limit);

// Bebaskan resource count query
sqlsrv_free_stmt($countQuery);

// Tutup koneksi database
sqlsrv_close($conn);

// Kirim response JSON
header('Content-Type: application/json');
echo json_encode([
    "status" => "success",
    "data" => $data,
    "totalPages" => $totalPages,
    "currentPage" => $page,
    "recordsPerPage" => $limit
]);
?>