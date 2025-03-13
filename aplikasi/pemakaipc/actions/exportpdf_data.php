<?php
// Mulai output buffering untuk mencegah output yang tidak diinginkan
ob_start();

// Mulai session jika diperlukan
session_start();

// Include konfigurasi koneksi
include('../../../config.php');

// Include class PDF dengan path relatif
require_once __DIR__ . '/pdf_class.php'; // Menggunakan __DIR__ untuk path dinamis

if ($conn === false) {
    ob_end_clean();
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

// Ambil data filter dari POST (dari form atau AJAX)
$divisi = isset($_POST['divisi']) ? $_POST['divisi'] : '';
$bagian = isset($_POST['bagian']) ? $_POST['bagian'] : '';
$subBagian = isset($_POST['subBagian']) ? $_POST['subBagian'] : '';
$lokasi = isset($_POST['lokasi']) ? $_POST['lokasi'] : '';
$bulan = isset($_POST['bulan']) ? $_POST['bulan'] : '';
$pcLaptop = isset($_POST['pcLaptop']) ? $_POST['pcLaptop'] : '';

// Buat query SQL berdasarkan filter
$query = "SELECT ippc, idpc, [user], namapc, divisi, bagian, subbagian, lokasi, prosesor, mobo, ram, harddisk, monitor, os, bulan, jumlah FROM [dbo].[pcaktif] WHERE 1=1";
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
    ob_end_clean();
    die("Query gagal: " . print_r(sqlsrv_errors(), true));
}

// Ambil semua data
$data = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

// Tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

// Jika tidak ada data, tampilkan pesan dan hentikan
if (empty($data)) {
    ob_end_clean();
    die("Tidak ada data yang tersedia untuk diekspor!");
}

// Inisialisasi class PDF
$pdf = new PDF('L', 'mm', 'A4'); // L untuk landscape, A4 sebagai ukuran kertas
$pdf->AddPage();

// Debugging: Pastikan path template benar
$templatePath = __DIR__ . '/../export/template_pdf.php';
if (!file_exists($templatePath)) {
    ob_end_clean();
    die("File template_pdf.php tidak ditemukan di: " . $templatePath);
}

// Panggil template untuk isi tabel
include '../export/template_pdf.php';

// Bersihkan buffer sebelum mengirim PDF
ob_end_clean();

// Output file PDF
$pdf->Output('D', 'daftar_pemakai_komputer_' . date('Ymd_His') . '.pdf');

exit;
?>