<?php
// Gunakan buffer output untuk menghindari error header
ob_start();

// Panggil konfigurasi koneksi
require_once __DIR__ . '/../config.php';

// Cek apakah koneksi tersedia
if (!$conn) {
    die(json_encode(array("error" => "Koneksi ke database gagal.")));
}

// Mendapatkan data dari request JSON
$jsonInput = trim(file_get_contents('php://input'));
$data = json_decode($jsonInput, true);

// Debugging: Cek apakah request JSON diterima dengan benar
if (!$data) {
    error_log("Request JSON kosong atau tidak valid.");
    die(json_encode(array("error" => "Request JSON kosong atau tidak valid. Pastikan Content-Type: application/json.")));
}

error_log("Request JSON: " . json_encode($data));

// Ambil parameter pagination
$start = isset($data['start']) ? intval($data['start']) : 0;
$length = isset($data['length']) ? intval($data['length']) : 100;

// Inisialisasi query dasar
$query = "SELECT * FROM pcaktif WHERE 1=1";
$params = array();

// Tambahkan filter berdasarkan input
if (!empty($data['divisi'])) {
    $query .= " AND divisi = ?";
    $params[] = $data['divisi'];
}
if (!empty($data['bagian'])) {
    $query .= " AND bagian = ?";
    $params[] = $data['bagian'];
}
if (!empty($data['subbagian'])) {
    $query .= " AND subbagian = ?";
    $params[] = $data['subbagian'];
}
if (!empty($data['lokasi'])) {
    $query .= " AND lokasi = ?";
    $params[] = $data['lokasi'];
}
if (!empty($data['bulan'])) {
    $query .= " AND bulan = ?";
    $params[] = $data['bulan'];
}
if (!empty($data['model'])) {
    $query .= " AND model = ?";
    $params[] = $data['model'];
}

// Tambahkan pagination
$query .= " ORDER BY ippc DESC OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
$params[] = $start;
$params[] = $length;

// Eksekusi query menggunakan sqlsrv
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(json_encode(array("error" => "Query gagal: " . print_r(sqlsrv_errors(), true))));
}

// Ambil hasil query
$output = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $output[] = $row;
}

// Jika tombol Clear diklik, kirim semua data tanpa filter
if (!empty($data['clear'])) {
    $query = "SELECT * FROM pcaktif ORDER BY ippc DESC OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
    $stmt = sqlsrv_query($conn, $query, array($start, $length));

    if ($stmt === false) {
        die(json_encode(array("error" => "Query gagal: " . print_r(sqlsrv_errors(), true))));
    }

    $output = array();
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $output[] = $row;
    }
}

// Bersihkan buffer sebelum mengirim JSON response
ob_clean();
header('Content-Type: application/json');

// Kirim hasil dalam format JSON
echo json_encode($output);

// Tutup koneksi SQL Server
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
