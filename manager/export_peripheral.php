<?php
include("../config.php"); // Panggil koneksi database SQL Server

// Pastikan koneksi tersedia
if (!$conn) {
    header('Content-Type: application/json');
    die(json_encode(["error" => "Koneksi database tidak valid."]));
}

// Jika tanpa filter, ambil semua data
if (isset($_POST['all_data']) && $_POST['all_data'] == "true") {
    $query = "SELECT nomor, id_perangkat, perangkat, tipe, [user], divisi, bulan, tgl_perawatan 
              FROM peripheral 
              ORDER BY nomor ASC";
    $params = [];
} else {
    // Ambil filter dari AJAX dan bersihkan spasi yang tidak perlu
    $filterPerangkat = isset($_POST['perangkat']) ? trim($_POST['perangkat']) : '';
    $filterTipe = isset($_POST['tipe']) ? trim($_POST['tipe']) : '';
    $filterUser = isset($_POST['user']) ? trim($_POST['user']) : '';
    $filterBulan = isset($_POST['bulan']) ? trim($_POST['bulan']) : '';
    $filterDivisi = isset($_POST['divisi']) ? trim($_POST['divisi']) : '';

    // Bangun query dengan filter
    $query = "SELECT nomor, id_perangkat, perangkat, tipe, [user], divisi, bulan, tgl_perawatan 
              FROM peripheral WHERE 1=1";
    $params = [];

    if (!empty($filterPerangkat)) {
        $query .= " AND perangkat = ?";
        $params[] = $filterPerangkat;
    }
    if (!empty($filterTipe)) {
        $query .= " AND tipe = ?";
        $params[] = $filterTipe;
    }
    if (!empty($filterUser)) {
        $query .= " AND [user] = ?"; // [user] karena 'user' adalah kata kunci di SQL Server
        $params[] = $filterUser;
    }
    if (!empty($filterBulan) && $filterBulan !== '00') { // "00" untuk semua bulan
        $query .= " AND bulan = ?";
        $params[] = $filterBulan;
    }
    if (!empty($filterDivisi)) {
        $query .= " AND divisi = ?";
        $params[] = $filterDivisi;
    }

    // Tambahkan ORDER BY di akhir query
    $query .= " ORDER BY nomor ASC";
}

// Jalankan query dengan prepared statement
$stmt = sqlsrv_prepare($conn, $query, $params);
if ($stmt === false) {
    header('Content-Type: application/json');
    die(json_encode(["error" => "Persiapan query gagal: " . print_r(sqlsrv_errors(), true)]));
}

if (!sqlsrv_execute($stmt)) {
    header('Content-Type: application/json');
    die(json_encode(["error" => "Eksekusi query gagal: " . print_r(sqlsrv_errors(), true)]));
}

// Simpan hasil query ke dalam array
$data = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    // Konversi tanggal jika ada (SQL Server mengembalikan DateTime object)
    if ($row['tgl_perawatan'] instanceof DateTime) {
        $row['tgl_perawatan'] = $row['tgl_perawatan']->format('Y-m-d');
    }
    $data[] = $row;
}

// Simpan hasil ke dalam file JSON sementara
$file = '../excel/export_data_peripheral.json';
if (file_put_contents($file, json_encode($data)) === false) {
    header('Content-Type: application/json');
    die(json_encode(["error" => "Gagal menyimpan file JSON."]));
}

// Kirim nama file JSON ke AJAX
header('Content-Type: application/json');
echo json_encode(["file" => $file]);

// Bersihkan resource dan tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>