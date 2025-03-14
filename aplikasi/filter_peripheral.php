<?php
// Sertakan file konfigurasi database
include('../config.php'); // Pastikan koneksi SQL Server diambil dari config.php

// Pastikan koneksi tersedia
if (!$conn) {
    header('Content-Type: application/json');
    die(json_encode(["error" => "Koneksi database tidak valid."]));
}

// Mendapatkan data dari request JSON
$data = json_decode(file_get_contents('php://input'), true);

// Debugging: Cek apakah request JSON diterima dengan benar
error_log("Request JSON: " . json_encode($data));

// Inisialisasi query dasar dengan parameter
$query = "SELECT nomor, id_perangkat, perangkat, tipe, [user], divisi, bulan, tgl_perawatan 
          FROM peripheral 
          WHERE 1=1";
$params = [];

// Tambahkan filter berdasarkan input
if (!empty($data['perangkat'])) {
    $query .= " AND perangkat = ?";
    $params[] = $data['perangkat'];
}
if (!empty($data['tipe'])) {
    $query .= " AND tipe = ?";
    $params[] = $data['tipe'];
}
if (!empty($data['user'])) {
    $query .= " AND [user] = ?"; // [user] karena 'user' adalah kata kunci di SQL Server
    $params[] = $data['user'];
}
if (!empty($data['bulan']) && $data['bulan'] !== '00') { // "00" untuk menampilkan semua bulan
    $query .= " AND bulan = ?";
    $params[] = $data['bulan'];
}
if (!empty($data['divisi'])) {
    $query .= " AND divisi = ?";
    $params[] = $data['divisi'];
}

// Jika tombol Reset (Clear) diklik, tampilkan semua data tanpa filter
if (!empty($data['clear'])) {
    $query = "SELECT nomor, id_perangkat, perangkat, tipe, [user], divisi, bulan, tgl_perawatan 
              FROM peripheral 
              ORDER BY tipe ASC";
    $params = [];
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
$output = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    // Konversi tanggal jika ada (SQL Server mengembalikan DateTime object)
    if ($row['tgl_perawatan'] instanceof DateTime) {
        $row['tgl_perawatan'] = $row['tgl_perawatan']->format('Y-m-d');
    }
    $output[] = $row;
}

// Kirim hasil dalam format JSON
header('Content-Type: application/json');
echo json_encode($output);

// Bersihkan resource dan tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>