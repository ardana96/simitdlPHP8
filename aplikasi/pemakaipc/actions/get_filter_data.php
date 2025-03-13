<?php
// Include konfigurasi koneksi
include('../../../config.php');

header('Content-Type: application/json');

// Debugging: Tambahkan log untuk memastikan file diakses
error_log("get_filter_data.php diakses");

// Periksa koneksi database
if ($conn === false) {
    error_log("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
    echo json_encode(['error' => 'Koneksi database gagal: ' . print_r(sqlsrv_errors(), true)]);
    exit;
}

if (isset($_GET['table']) && $_GET['table'] === 'bulan') {
    // Khusus untuk tabel bulan
    $valueColumn = isset($_GET['valueColumn']) ? $_GET['valueColumn'] : 'id_bulan';
    $textColumn = isset($_GET['textColumn']) ? $_GET['textColumn'] : 'bulan';

    $query = "SELECT [$valueColumn], [$textColumn] FROM [dbo].[bulan] WHERE [$valueColumn] IS NOT NULL AND [$textColumn] IS NOT NULL ORDER BY [$valueColumn]";
    $result = sqlsrv_query($conn, $query);

    if ($result === false) {
        error_log("Query gagal untuk bulan: " . print_r(sqlsrv_errors(), true));
        echo json_encode(['error' => 'Query gagal: ' . print_r(sqlsrv_errors(), true)]);
        exit;
    }

    $data = [];
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }

    error_log("Data ditemukan untuk bulan: " . count($data));
    echo json_encode($data);
} else {
    $column = isset($_GET['column']) ? $_GET['column'] : '';

    if ($column) {
        // Pastikan kolom yang diminta ada di tabel [dbo].[pcaktif]
        $validColumns = ['divisi', 'bagian', 'subbagian', 'lokasi', 'bulan', 'model'];
        if (!in_array($column, $validColumns)) {
            error_log("Kolom tidak valid: " . $column);
            echo json_encode(['error' => 'Kolom tidak valid']);
            exit;
        }

        // Query untuk mengambil data unik dari kolom di [dbo].[pcaktif]
        $query = "SELECT DISTINCT [$column] FROM [dbo].[pcaktif] WHERE [$column] IS NOT NULL";
        $result = sqlsrv_query($conn, $query);

        if ($result === false) {
            error_log("Query gagal: " . print_r(sqlsrv_errors(), true));
            echo json_encode(['error' => 'Query gagal: ' . print_r(sqlsrv_errors(), true)]);
            exit;
        }

        $data = [];
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $data[] = $row[$column];
        }

        error_log("Data ditemukan untuk kolom $column: " . count($data));
        sort($data);
        echo json_encode($data);
    } else {
        error_log("Parameter kolom tidak ditemukan");
        echo json_encode(['error' => 'Parameter kolom tidak ditemukan']);
    }
}

// Tutup koneksi
sqlsrv_close($conn);
?>