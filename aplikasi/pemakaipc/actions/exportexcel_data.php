<?php
// Mulai session jika diperlukan
session_start();

// Include konfigurasi koneksi
include('../../../config.php');

if ($conn === false) {
    die(json_encode(array('status' => 'error', 'message' => 'Koneksi database gagal: ' . print_r(sqlsrv_errors(), true))));
}

// Set header agar file di-download sebagai Excel
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=daftar_pemakai_komputer_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Tambahkan BOM UTF-8 agar karakter terbaca dengan benar di Excel
echo "\xEF\xBB\xBF";

// Ambil data filter dari AJAX
$divisi = isset($_POST['divisi']) ? $_POST['divisi'] : '';
$bagian = isset($_POST['bagian']) ? $_POST['bagian'] : '';
$subBagian = isset($_POST['subBagian']) ? $_POST['subBagian'] : '';
$lokasi = isset($_POST['lokasi']) ? $_POST['lokasi'] : '';
$bulan = isset($_POST['bulan']) ? $_POST['bulan'] : '';
$pcLaptop = isset($_POST['pcLaptop']) ? $_POST['pcLaptop'] : '';

// Buat query SQL berdasarkan filter
$query = "SELECT ippc, idpc, [user], namapc, divisi, bagian, subbagian, lokasi, prosesor, mobo, ram, harddisk, monitor, os, bulan, tgl_perawatan, jumlah FROM [dbo].[pcaktif] WHERE 1=1";
$params = array();

if (!empty($divisi)) {
    $query .= " AND divisi LIKE ?";
    $params[] = "%$divisi%";
}
if (!empty($bagian)) {
    $query .= " AND bagian LIKE ?";
    $params[] = "%$bagian%";
}
if (!empty($subBagian)) {
    $query .= " AND subbagian LIKE ?";
    $params[] = "%$subBagian%";
}
if (!empty($lokasi)) {
    $query .= " AND lokasi LIKE ?";
    $params[] = "%$lokasi%";
}
if (!empty($bulan)) {
    $query .= " AND bulan LIKE ?";
    $params[] = "%$bulan%";
}
if (!empty($pcLaptop)) {
    $query .= " AND model = ?";
    $params[] = $pcLaptop;
}

// Tambahkan ORDER BY untuk konsistensi
$query .= " ORDER BY idpc ASC";

// Eksekusi query
$stmt = sqlsrv_query($conn, $query, $params);
if ($stmt === false) {
    die(json_encode(array('status' => 'error', 'message' => 'Query gagal: ' . print_r(sqlsrv_errors(), true))));
}

// Ambil semua data
$data = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    // Jika tgl_perawatan adalah tipe DateTime, format ke string
    if (isset($row['tgl_perawatan']) && $row['tgl_perawatan'] instanceof DateTime) {
        $row['tgl_perawatan'] = $row['tgl_perawatan']->format('Y-m-d');
    }
    $data[] = $row;
}

// Tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

// Jika tidak ada data, tampilkan pesan
if (empty($data)) {
    echo "<table border='1'><tr><td colspan='15' style='text-align:center; font-weight:bold; color:red;'>Tidak ada data yang tersedia!</td></tr></table>";
    exit;
}

// Simpan data ke variabel untuk dikirim ke template
$templateData = $data;

// Debugging: Pastikan path template benar
$templatePath = __DIR__ . '/../export/template_excel.php';
if (!file_exists($templatePath)) {
    die("File template_excel.php tidak ditemukan di: " . $templatePath);
}

// Panggil template untuk membangun file Excel
include '../export/template_excel.php';

exit;
?>