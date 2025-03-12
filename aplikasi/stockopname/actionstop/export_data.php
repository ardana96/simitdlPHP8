<?php
// Mulai session jika diperlukan
session_start();

// Include konfigurasi koneksi
include('../../../config.php');

if ($conn === false) {
    die(json_encode(array('status' => 'error', 'message' => 'Koneksi database gagal: ' . print_r(sqlsrv_errors(), true))));
}

// Include library mPDF dengan pengecekan
$autoloadPath = __DIR__ . '/../../../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    die(json_encode(array('status' => 'error', 'message' => 'File vendor/autoload.php tidak ditemukan di: ' . $autoloadPath . '. Pastikan Composer dan mPDF terinstall.')));
}
require_once $autoloadPath;

// Periksa apakah kelas Mpdf\Mpdf tersedia
if (!class_exists('Mpdf\Mpdf')) {
    die(json_encode(array('status' => 'error', 'message' => 'Kelas Mpdf\Mpdf tidak ditemukan. Pastikan mPDF terinstall dengan benar. Cek isi vendor/mpdf/mpdf/src/Mpdf.php.')));
}
use Mpdf\Mpdf;

// Ambil data filter dari AJAX
$divisi = isset($_POST['divisi']) ? $_POST['divisi'] : '';
$bagian = isset($_POST['bagian']) ? $_POST['bagian'] : '';
$subBagian = isset($_POST['subBagian']) ? $_POST['subBagian'] : '';
$lokasi = isset($_POST['lokasi']) ? $_POST['lokasi'] : '';
$bulan = isset($_POST['bulan']) ? $_POST['bulan'] : '';
$pcLaptop = isset($_POST['pcLaptop']) ? $_POST['pcLaptop'] : '';

// Buat query SQL berdasarkan filter
$query = "SELECT * FROM [dbo].[pcaktif] WHERE 1=1";
$params = array();

if (!empty($divisi)) {
    $query .= " AND divisi = ?";
    $params[] = $divisi;
}
if (!empty($bagian)) {
    $query .= " AND bagian = ?";
    $params[] = $bagian;
}
if (!empty($subBagian)) {
    $query .= " AND subbagian = ?";
    $params[] = $subBagian;
}
if (!empty($lokasi)) {
    $query .= " AND lokasi = ?";
    $params[] = $lokasi;
}
if (!empty($bulan)) {
    $query .= " AND bulan = ?";
    $params[] = $bulan;
}
if (!empty($pcLaptop)) {
    $query .= " AND model = ?";
    $params[] = $pcLaptop;
}

// Eksekusi query
$stmt = sqlsrv_query($conn, $query, $params);
if ($stmt === false) {
    die(json_encode(array('status' => 'error', 'message' => 'Query gagal: ' . print_r(sqlsrv_errors(), true))));
}

// Ambil semua data
$data = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

// Tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

// Jika tidak ada data, kembalikan error
if (empty($data)) {
    echo json_encode(array('status' => 'error', 'message' => 'Tidak ada data untuk diekspor.'));
    exit;
}

// Kirim data ke template_pdf.php dengan pengecekan
$templatePath = __DIR__ . '/../export/template_pdf.php';
if (!file_exists($templatePath)) {
    die(json_encode(array('status' => 'error', 'message' => 'File template_pdf.php tidak ditemukan di: ' . $templatePath)));
}
ob_start();
require $templatePath;
$html = ob_get_clean();

// Inisialisasi mPDF
$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4-L', // Landscape A4
    'margin_left' => 10,
    'margin_right' => 10,
    'margin_top' => 10,
    'margin_bottom' => 10,
]);

// Tulis HTML ke PDF
$mpdf->WriteHTML($html);

// Buat nama file unik untuk PDF
$timestamp = date('Ymd_His');
$pdfFileName = "stockopname_report_{$timestamp}.pdf";
$pdfFilePath = __DIR__ . "/pdf_output/{$pdfFileName}"; // Tetap simpan di aplikasi/stockopname/actionstop/pdf_output/

// Pastikan folder pdf_output ada dan memiliki izin tulis
if (!is_dir(__DIR__ . '/pdf_output')) {
    mkdir(__DIR__ . '/pdf_output', 0777, true);
}

// Simpan file PDF
$mpdf->Output($pdfFilePath, 'F'); // 'F' berarti simpan ke file

// Buat URL untuk file PDF
$pdfUrl = "http://10.110.30.219/simitdlPHP8/aplikasi/stockopname/actionstop/pdf_output/{$pdfFileName}";

// Kembalikan respons JSON dengan URL file PDF
echo json_encode(array(
    'status' => 'success',
    'pdfUrl' => $pdfUrl,
    'message' => 'PDF berhasil diekspor.'
));
exit;
?>